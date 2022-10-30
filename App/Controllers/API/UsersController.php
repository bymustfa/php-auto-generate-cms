<?php
namespace App\Controllers\API;

use Core\Controller;

use App\Models\API\UsersModel;
use App\Schemas\API\UsersSchema;

class UsersController extends Controller
{
    public $apiModel = UsersModel::class;
    public $schemaClass = UsersSchema::class;

      /**
         * @OA\Get(
         *   path="/api/users/getAll",
         *   summary="Get all datas",
         *   tags={"Users"},

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
         *   path="/api/users/getOne/{id}",
         *   summary="Get one",
         *   tags={"Users"},
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
         *   path="/api/users/create",
         *   summary="Create",
         *   tags={"Users"},
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
         *   path="/api/users/createMulti",
         *   summary="Create Multi",
         *   tags={"Users"},
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
         *   path="/api/users/update/{id}",
         *   summary="Update",
         *   tags={"Users"},
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
         *   path="/api/users/delete/{id}",
         *   summary="Delete",
         *   tags={"Users"},
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
         *   path="/api/users/filter",
         *   summary="Filter Datas",
         *   tags={"Users"},
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
