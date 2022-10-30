<?php

namespace Core;

use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(title="Auto Generate CMS", version="0.1", description="Auto Generate CMS")
 * @OA\Server(url=BASE_URL)
 */
class Controller extends Bootstrap
{
    public $apiModel;
    public $schemaClass;


    public function GetAll(Request $request)
    {
        try {
            $page = get('page');
            $perPage = get('perPage');

            $model = new $this->apiModel();
            $data = $model->get();

            $relations = $model->relations;
            if (count($relations) > 0) {
                foreach ($relations as $relation) {
                    $data = $data->load($relation['methodName']);
                }
            }

            $orderBy = get('orderBy');
            $order = get('order');
            $order = $order ?? "asc";
            if ($orderBy) {
                $data = $data->sortBy($orderBy, strtolower($order) == "desc" ? SORT_REGULAR : SORT_NATURAL, strtolower($order) == "desc");
            }

            if ($page && $perPage) {
                $data = json_decode($model->paginate($perPage, ['*'], 'page', $page)->toJson(), true);
                $data['count'] = $data['total'];
                $data['datas'] = $data['data'];
                unset($data['total']);
                unset($data['data']);
            }

            response([
                'status' => true,
                'message' => 'Get All Datas Successfully',
                'data' =>
                    $page && $perPage ? $data : [
                        'count' => $data->count(),
                        'datas' => $data
                    ]
            ]);
        } catch (\Exception $e) {
            $message = errorMessageConvert($e->getMessage());
            response([
                'status' => false,
                'message' => $message
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function GetOne(Request $request, $id)
    {
        try {
            $model = new $this->apiModel();
            $data = $model->find($id);
            response([
                'status' => true,
                'message' => 'Get One Data Successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            $message = errorMessageConvert($e->getMessage());
            response([
                'status' => false,
                'message' => $message
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function Create(Request $request)
    {
        $model = new $this->apiModel();
        try {
            $model->beginTransaction();
            $entityBody = dataClear(json_decode($request->getContent(), true));

            $schema = new $this->schemaClass();
            $fields = $schema->fields;
            $fieldTypes = $schema->fieldTypes;

            foreach ($entityBody as $key => $value) {
                $form_type = $fields[$key]['form_type'];
                $form_pattern = $fieldTypes[$form_type]['form_pattern'] ?? null;
                if ($form_pattern && !preg_match($form_pattern, $value)) {
                    $formLabel = $fields[$key]['form_label'] ?? $key;
                    throw new \Exception("Invalid '$formLabel'");
                }
            }

            $data = $model->create($entityBody);
            $model->commit();
            response([
                'status' => true,
                'message' => 'Create Data Successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            $model->rollBack();
            $message = errorMessageConvert($e->getMessage());
            response([
                'status' => false,
                'message' => $message
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function CreateMulti(Request $request)
    {
        $model = new $this->apiModel();
        try {
            $model->beginTransaction();
            $entityBody = dataClear(json_decode($request->getContent(), true));

            $saveDatas = [];

            foreach ($entityBody as $key => $value) {
                $saveDatas[] = $model->create($value);
            }
            $model->commit();
            response([
                'status' => true,
                'message' => 'Create Multi Data Successfully',
                'data' => $saveDatas
            ]);
        } catch (\Exception $e) {
            $model->rollBack();
            $message = errorMessageConvert($e->getMessage());
            response([
                'status' => false,
                'message' => $message
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function Update(Request $request, $id)
    {
        $model = new $this->apiModel();
        try {
            $model->beginTransaction();
            $entityBody = dataClear(json_decode($request->getContent(), true));
            $data = $model->find($id);
            if (!$data) {
                throw new \Exception("Data not found");
            }
            $data->update($entityBody);
            $model->commit();
            response([
                'status' => true,
                'message' => 'Update Data Successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            $model->rollBack();
            $message = errorMessageConvert($e->getMessage());
            response([
                'status' => false,
                'message' => $message
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function Delete(Request $request, $id)
    {
        $model = new $this->apiModel();
        try {
            $model->beginTransaction();
            $data = $model->find($id);
            if (!$data) {
                throw new \Exception("Data not found");
            }
            $data->delete();
            $model->commit();
            response([
                'status' => true,
                'message' => 'Delete Data Successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            $model->rollBack();
            $message = errorMessageConvert($e->getMessage());
            response([
                'status' => false,
                'message' => $message
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function Filter(Request $request)
    {
        try {
            $page = get('page');
            $perPage = get('perPage');

            $data = new $this->apiModel();
            $entityBody = dataClear(json_decode($request->getContent(), true));

            foreach ($entityBody as $filterData) {
                $column = $filterData['column'];
                $operator = $filterData['operator'];
                $value = strtolower($operator) == "like" ? "%{$filterData['value']}%" : $filterData['value'];
                $data = $data->where($column, $operator, $value);
            }

            $orderBy = get('orderBy');
            $order = get('order');
            $order = $order ?? "asc";
            if ($orderBy) {
                $data = $data->sortBy($orderBy, strtolower($order) == "desc" ? SORT_REGULAR : SORT_NATURAL, strtolower($order) == "desc");
            }

            if ($page && $perPage) {
                $data = json_decode($model->paginate($perPage, ['*'], 'page', $page)->toJson(), true);
                $data['count'] = $data['total'];
                $data['datas'] = $data['data'];
                unset($data['total']);
                unset($data['data']);
            }

            response([
                'status' => true,
                'message' => 'Filter Datas Successfully',
                'data' =>
                    $page && $perPage ? $data : [
                        'count' => $data->count(),
                        'datas' => $data
                    ]
            ]);
        } catch (\Exception $e) {
            $message = errorMessageConvert($e->getMessage());
            response([
                'status' => false,
                'message' => $message
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}

?>
