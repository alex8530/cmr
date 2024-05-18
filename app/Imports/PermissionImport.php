<?php

namespace App\Imports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\PermissionGroup;
use DB;
class PermissionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //  info( "alex::: PermissionImport" .$row[0] .'>>>' .$row[1] );

          
         try {
            PermissionGroup::create([
                    'name'=>$row[1] 
                ]);   
         info( "alex::: PermissionGroup created:: "  .$row[1] );

      } catch (\Exception $e) {
        info("alex::: error dublicate group PermissionGroup" .$row[1] );

      }


        // info( "alex:::". $row);
        return new Permission([
            'name'     => $row[0],
            'group_name'    => $row[1], 
        ]);
    }
}
