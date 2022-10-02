<?php


namespace App\Controllers\CMS;

use App\Models\CMS\Restaurants;
use Symfony\Component\HttpFoundation\Request;
use Core\Controller;


class RestaurantsController extends Controller
{

    public function create(Request $request)
    {
        $headers = $request->headers->all();
        try {
            Restaurants::beginTransaction();

            $postData = $request->getContent();
            $postData = json_decode($postData, true);

            foreach ($postData as $key => $value) {
                $key = dataClear($key);
                $value = dataClear($value);
                $postData[$key] = $value;
            }
            $add = Restaurants::create($postData);
            if ($add) {
                Restaurants::commit();
                controllerResponse($headers, "Restaurants Başarıyla Eklendi", $add);
            } else {
                Restaurants::rollBack();
                throw new \Exception("Restaurants Ekleme Başarısız");
            }
        } catch (\Exception $e) {
            Restaurants::rollBack();
            $message = $e->getMessage();
            controllerResponse($headers, $message, null, false, 500);
        }
    }

    public function filter(Request $request)
    {
         $headers = $request->headers->all();
        try {
             Restaurants::beginTransaction();

            $filters = $request->getContent();

            if ($filters) {
                $filters = json_decode($filters, true);
                $datas = Restaurants::query();


                // where('city_name', 'like', '%lis%')
                foreach ($filters as $filter) {
                    $datas = $datas->where($filter['column'], $filter['operator'], $filter['value']);
                }

                $datas = $datas->get();

                if ($datas) {
                    Restaurants::commit();
                    controllerResponse($headers, "Restaurants Başarıyla Getirildi", ['count' => count($datas), 'data' => $datas]);
                } else {
                   Restaurants::rollBack();
                    throw new \Exception("Restaurants Getirme Başarısız");
                }
            } else {
               Restaurants::rollBack();
                throw new \Exception("Restaurants Getirme Başarısız");
            }
        } catch (\Exception $e) {
           Restaurants::rollBack();
            $message = $e->getMessage();
            controllerResponse($headers, $message, null, false, 500);
        }
    }

    public function update(Request $request, $id)
    {
         $headers = $request->headers->all();
        try {
             Restaurants::beginTransaction();

            $id = intval(dataClear($id));
            $putData = $request->getContent();
            $putData = json_decode($putData, true);

            foreach ($putData as $key => $value) {
                $key = dataClear($key);
                $value = dataClear($value);
                $putData[$key] = $value;
            }

            $find = Restaurants::find($id);
            if ($find) {

                $update = $find->update($putData);
                if ($update) {
                    Restaurants::commit();
                    controllerResponse($headers, "Restaurants Başarıyla Güncellendi", $update);
                } else {
                   Restaurants::rollBack();
                    throw new \Exception("Restaurants Güncelleme Başarısız");
                }
            } else {
               Restaurants::rollBack();
                throw new \Exception("Restaurants Güncelleme Başarısız");
            }
        } catch (\Exception $e) {
           Restaurants::rollBack();
            $message = $e->getMessage();
            controllerResponse($headers, $message, null, false, 500);
        }
    }

    public function delete(Request $request, $id)
    {
         $headers = $request->headers->all();
        try {
             Restaurants::beginTransaction();

            $id = intval(dataClear($id));
            $find = Restaurants::find($id);
            if ($find) {
                $delete = $find->delete();
                if ($delete) {
                 Restaurants::commit();
                    controllerResponse($headers, "Restaurants Başarıyla Silindi", $delete);
                } else {
                   Restaurants::rollBack();
                    throw new \Exception("Restaurants Silme Başarısız");
                }
            } else {
               Restaurants::rollBack();
                throw new \Exception("Restaurants Silme Başarısız");
            }
        } catch (\Exception $e) {
           Restaurants::rollBack();
            $message = $e->getMessage();
            controllerResponse($headers, $message, null, false, 500);
        }
    }

    public function getByID(Request $request, $id)
    {
         $headers = $request->headers->all();
        try {
            $id = intval(dataClear($id));
            $find = Restaurants::find($id);
            if ($find) {
                controllerResponse($headers, "Restaurants Başarıyla Getirildi", $find);
            } else {
                throw new \Exception("Restaurants Getirme Başarısız");
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            controllerResponse($headers, $message, null, false, 500);
        }
    }

    public function getAll(Request $request)
    {
         $headers = $request->headers->all();
        try {
            $find = Restaurants::all();
            if ($find) {
                controllerResponse($headers, "Restaurants Başarıyla Getirildi", ['count' => count($find), 'data' => $find]);
            } else {
                throw new \Exception("Restaurants Getirme Başarısız");
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            controllerResponse($headers, $message, null, false, 500);
        }
    }


}

?>

