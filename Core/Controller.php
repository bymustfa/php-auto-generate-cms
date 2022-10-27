<?php

namespace Core;

use Symfony\Component\HttpFoundation\Request;


class Controller extends Bootstrap
{
    public $apiModel;
    public $schemaClass;

    // TODO: Fix order and per page parameters

    // GET: getAll | ?page=1&perPage=5&orderBy=id&order=asc
    public function GetAll(Request $request)
    {
        try {
            $page = get('page');
            $perPage = get('perPage');


            $model = new $this->apiModel();
            $data = $model->get();

            $orderBy = get('orderBy');
            $order = get('order');
            $order = $order ?? "asc";
            if ($orderBy) {
                $data = $data->sortBy($orderBy, strtolower($order) == "desc" ? SORT_REGULAR : SORT_NATURAL, strtolower($order) == "desc");
            }

            if ($page && $perPage) {
                $data = $model->paginate($perPage, ['*'], 'page', $page);
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
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // GET: getAll/:id
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
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // POST: create
    public function Create(Request $request)
    {
        $model = new $this->apiModel();
        try {
            $model->beginTransaction();
            $entityBody = dataClear(json_decode($request->getContent(), true));
            $data = $model->create($entityBody);
            $model->commit();
            response([
                'status' => true,
                'message' => 'Create Data Successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            $model->rollBack();
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // POST: createMany
    public function CreateMany(Request $request)
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
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // PUT: update/:id
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
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE: delete/:id
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
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // POST: filter | ?page=1&perPage=5
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
                $data = $model->paginate($perPage, ['*'], 'page', $page);
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
            response([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}

?>
