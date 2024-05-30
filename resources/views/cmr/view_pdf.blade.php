<!DOCTYPE html>
<html>
<head>
    <title>View PDF</title>
    <!-- Include Bootstrap CSS -->
    <link href="{{'frontend/css/bootstrap.v4.5.2.min.css'}}" rel="stylesheet">
{{--    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">--}}
    <style>
        body {
            background-color: #f1f1f1;
            font-family: 'Arial', sans-serif;
        }

        #pdf-container {
            position: relative;
            text-align: center;
            margin-top: 3rem;
            margin-bottom: 2rem; /* Added margin bottom */

        }

        #pdf-canvas, #signature-pad {
            border: 1px solid black;
            margin-bottom: 1rem;
        }

        #navigation {
            margin: 10px 0;
        }

        #navigation button {
            margin-right: 10px;
        }

        #save-signature {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .btn {
            margin-right: 10px;
        }

        #signature-pad {
            margin-top: auto; /* Ensure signature-pad is at the bottom */
        }

        /* Centered loader */
        .loader-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000; /* Ensure it's above other content */
            /*display: none; !* Hide by default *!*/
        }

        .loader {
            border: 8px solid #f3f3f3; /* Light grey */
            border-top: 8px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite; /* Spin animation */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

    </style>
</head>
<body>
<div class="container">


    <div id="pdf-container">
        <canvas id="pdf-canvas" class="mb-3"></canvas>

        <div class="form-group">
            <h5 for="">Choose Signature Way</h5>
            <div class="form-check">
                @auth
                    <input id="predefined_signature" class="form-check-input" type="radio" value="1" name="signature_way">
                    <label class="form-check-label" for="predefined_signature">
                        Pre-Defined In My Profile
                    </label>
                @endauth
            </div>
            <div class="form-check">
                <input id="hand_way_signature" class="form-check-input" type="radio" checked value="2" name="signature_way">
                <label class="form-check-label" for="hand_way_signature">
                    Hand Way
                </label>
            </div>
        </div>


        <div id="signature_pad_div">

            <h5>Draw Your Signature Then Click In The PDF</h5>
       <canvas id="signature-pad" width="300" height="150"></canvas>

        </div>



    </div>
    <div id="navigation" class="text-center">
        <button id="prev-page" class="btn btn-primary">Previous</button>
        <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
        <button id="next-page" class="btn btn-primary">Next</button>
    </div>



    <button id="reset-canvas" class="btn btn-warning">Reset Canvas</button>
    <button id="save-signature" class="btn btn-success btn-block">Save Signature</button>




    <!-- Loader -->
    <div id="loader" class="loader-container ">
        <div class="loader"></div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies (optional but recommended) -->
<script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>

<script src="{{asset('frontend/js/popper.min.js')}}"></script>
<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>

<script src="{{asset('frontend/js/pdf.min.js')}}"></script>
<script src="{{asset('frontend/js/signature_pad.min.js')}}"></script>

<script>
    const url = '{{ Storage::url($path) }}';

    // Initialize PDF.js
    pdfjsLib.GlobalWorkerOptions.workerSrc = '{{asset("frontend/js/pdf.worker.min.js")}}';

    const pdfCanvas = document.getElementById('pdf-canvas');
    const context = pdfCanvas.getContext('2d');
    const signaturePad = new SignaturePad(document.getElementById('signature-pad'));
    let pdfDoc = null;
    let pageNum = 1;
    let pageRendering = false;
    let pageNumPending = null;
    let signaturePosition = null;

    function renderPage(num) {
        pageRendering = true;

        return pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({scale: 1.5});
            pdfCanvas.width = viewport.width;
            pdfCanvas.height = viewport.height;

            const renderContext = {
                canvasContext: context,
                viewport: viewport
            };

            const renderTask = page.render(renderContext);

            return renderTask.promise.then(() => {
                pageRendering = false;

                if (pageNumPending !== null) {
                    renderPage(pageNumPending).then(() => {
                        pageNumPending = null;
                    });
                }
                document.getElementById('page-num').textContent = num;
            });
        });
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function onPrevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
        updatePageButtons();
    }

    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
        updatePageButtons();
    }

    document.getElementById('prev-page').addEventListener('click', onPrevPage);
    document.getElementById('next-page').addEventListener('click', onNextPage);

    pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;
        document.getElementById('page-count').textContent = pdfDoc.numPages;
        renderPage(pageNum);
        updatePageButtons();
    });

    pdfCanvas.addEventListener('click', (event) => {
        const rect = pdfCanvas.getBoundingClientRect();
        let x = (event.clientX - rect.left) * (pdfCanvas.width / rect.width);
        let y = (event.clientY - rect.top) * (pdfCanvas.height / rect.height);
        x = x - (300 / 4);
        y = y - (150 / 4);
        signaturePosition = {x, y};
        console.log('Signature position:', signaturePosition);
        showSignaturePreview(x, y);
    });

    function showSignaturePreview(x, y) {
        renderPage(pageNum).then(() => {
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = signaturePad._canvas.width;
            tempCanvas.height = signaturePad._canvas.height;
            const tempContext = tempCanvas.getContext('2d');
            tempContext.drawImage(signaturePad._canvas, 0, 0);

            const scaledWidth = tempCanvas.width / 2;
            const scaledHeight = tempCanvas.height / 2;


            if ( $('#hand_way_signature').is(':checked')) {
                context.drawImage(tempCanvas, x, y, scaledWidth, scaledHeight);
            }else {
                let image =  new Image();
                image.src = '{{url('storage/'.auth()->user()->signaturePath) }}';
                image.onload = function () {
                    context.drawImage(image, x, y, scaledWidth, scaledHeight);
                };
            }

        });
    }

    document.getElementById('save-signature').addEventListener('click', () => {

        let signatureWay =''

        if ( $('#hand_way_signature').is(':checked')) {

            signatureWay= $('#hand_way_signature').val();
        }else {
            signatureWay= $('#predefined_signature').val();

        }


        if (signaturePad.isEmpty()) {
            alert('Please provide a signature first.');
            return;
        }

        if (!signaturePosition) {
            alert('Please click on the PDF to place your signature.');
            return;
        }

        // Show loader
        // document.getElementById('loader').classList.remove('d-none');
        document.getElementById('loader').style.visibility = 'visible';


        const dataUrl = signaturePad.toDataURL();
        const pdfPath = '{{ $path }}';
        fetch('{{ route('save.signature') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                signature: dataUrl,
                pdf_path: pdfPath,
                position: signaturePosition,
                page: pageNum,
                canvas_width: pdfCanvas.width,
                canvas_height: pdfCanvas.height,
                page_num: pageNum,
                signature_way:signatureWay
            })
        })
            .then(response => response.blob())
            .then(blob => {
                // Hide loader
                // document.getElementById('loader').classList.add('d-none');
                document.getElementById('loader').style.visibility = 'hidden';


                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = 'signed.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(error => {
                // Hide loader
                // document.getElementById('loader').classList.add('d-none');
                document.getElementById('loader').style.visibility = 'hidden';

                console.error('Error:', error);
            });
    });

    // Add event listener to the reset button
    document.getElementById('reset-canvas').addEventListener('click', resetCanvas);

    function updatePageButtons() {
        const prevButton = document.getElementById('prev-page');
        const nextButton = document.getElementById('next-page');
        prevButton.disabled = pageNum <= 1;
        nextButton.disabled = pageNum >= pdfDoc.numPages;
    }

    function resetCanvas() {
        // Clear the PDF canvas
        // context.clearRect(0, 0, pdfCanvas.width, pdfCanvas.height);

        // Clear the signature pad
        signaturePad.clear();
    }

</script>
<script>
    $(document).ready(function () {
        document.getElementById('loader').style.visibility = 'hidden';


        $('#signature_pad_div').show()


            $('#predefined_signature').click(function (event) {

                    $('#signature_pad_div').hide()
                }
            );

            $('#hand_way_signature').click(function (event) {

                    $('#signature_pad_div').show()
                }
            );


        }
    );


</script>
</body>
</html>
