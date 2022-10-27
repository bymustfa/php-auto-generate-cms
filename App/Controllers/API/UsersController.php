<?php
namespace App\Controllers\API;

use Core\Controller;

use App\Models\API\UsersModel;
use App\Schemas\API\UsersSchema;

class UsersController extends Controller
{
    public $apiModel = UsersModel::class;
    public $schemaClass = UsersSchema::class;


}

?>
