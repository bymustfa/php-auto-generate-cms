<?php
namespace App\Controllers\API;

use Core\Controller;

use App\Models\API\ExperiencesModel;
use App\Schemas\API\ExperiencesSchema;

class ExperiencesController extends Controller
{
    public $apiModel = ExperiencesModel::class;
    public $schemaClass = ExperiencesSchema::class;

      /**
         * @OA\Get(
         *   path="/api/experiences/getAll",
         *   summary="Get all datas",
         *   tags={"Experiences"},

                   * @OA\Parameter(
                   *     name="page",
                   *     in="query",
                   *     description="Page number",
                   *     required=false,
                   * ),

                   * @OA\Parameter(
                   *     name="perPage",
                   *     in="query",
                   *     description="Number of items per page",
                   *     required=false,
                   * ),

                  * @OA\Parameter(
                  *     name="orderBy",
                  *     in="query",
                  *     description="Order by",
                  *     required=false,
                  * ),

                   * @OA\Parameter(
                   *     name="order",
                   *     in="query",
                   *     description="Order Column Name",
                   *     required=false,
                   * ),

         *   @OA\Response(
         *     response=200,
         *     description="Success"
         *   )
         * )
         */
        public function GetAllDatas(Request $request)
        {
            return parent::GetAll($request);
        }


        /**
         * @OA\Get(
         *   path="/api/experiences/getOne/{id}",
         *   summary="Get one",
         *   tags={"Experiences"},
          *     @OA\Parameter(
          *     name="id",
          *     in="path",
          *     description="ID of data to return",
          *     required=true,
          *     ),
         *   @OA\Response(
         *     response=200,
         *     description="Success"
         *   )
         * )
         */
        public function GetOneDatas(Request $request)
        {
            return parent::GetOne($request);
        }



        /**
         * @OA\Post(
         *   path="/api/experiences/create",
         *   summary="Create",
         *   tags={"Experiences"},
         *   @OA\Response(
         *     response=200,
         *     description="Success"
         *   )
         * )
         */
        public function CreateDatas(Request $request)
        {
            return parent::Create($request);
        }


        /**
         * @OA\Post(
         *   path="/api/experiences/createMulti",
         *   summary="Create Multi",
         *   tags={"Experiences"},
         *   @OA\Response(
         *     response=200,
         *     description="Success"
         *   )
         * )
         */
        public function CreateMultiDatas(Request $request)
        {
            return parent::CreateMulti($request);
        }



        /**
         * @OA\Put(
         *   path="/api/experiences/update/{id}",
         *   summary="Update",
         *   tags={"Experiences"},
              *     @OA\Parameter(
                   *     name="id",
                   *     in="path",
                   *     description="ID of data to return",
                   *     required=true,
                   *     ),
         *   @OA\Response(
         *     response=200,
         *     description="Success"
         *   )
         * )
         */
        public function UpdateData(Request $request)
        {
            return parent::Update($request);
        }


        /**
         * @OA\Delete(
         *   path="/api/experiences/delete/{id}",
         *   summary="Delete",
         *   tags={"Experiences"},
              *     @OA\Parameter(
                   *     name="id",
                   *     in="path",
                   *     description="ID of data to return",
                   *     required=true,
                   *     ),
         *   @OA\Response(
         *     response=200,
         *     description="Success"
         *   )
         * )
         */
        public function DeleteData(Request $request)
        {
            return parent::Delete($request);
        }



        /**
         * @OA\Post(
         *   path="/api/experiences/filter",
         *   summary="Filter Datas",
         *   tags={"Experiences"},
                   * @OA\Parameter(
                   *     name="page",
                   *     in="query",
                   *     description="Page number",
                   *     required=false,
                   * ),

                   * @OA\Parameter(
                   *     name="perPage",
                   *     in="query",
                   *     description="Number of items per page",
                   *     required=false,
                   * ),

                  * @OA\Parameter(
                  *     name="orderBy",
                  *     in="query",
                  *     description="Order by",
                  *     required=false,
                  * ),

                   * @OA\Parameter(
                   *     name="order",
                   *     in="query",
                   *     description="Order Column Name",
                   *     required=false,
                   * ),
         *   @OA\Response(
         *     response=200,
         *     description="Success"
         *   )
         * )
         */
        public function FilterDatas(Request $request)
        {
            return parent::Filter($request);
        }
}

?>
