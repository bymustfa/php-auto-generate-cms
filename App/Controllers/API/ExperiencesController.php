<?php
namespace App\Controllers\API;

use Core\Controller;

use App\Models\API\ExperiencesModel;
use App\Schemas\API\ExperiencesSchema;
use Symfony\Component\HttpFoundation\Request;

class ExperiencesController extends Controller
{
    public $apiModel = ExperiencesModel::class;
    public $schemaClass = ExperiencesSchema::class;

}

?>
