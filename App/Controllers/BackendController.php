<?php

namespace App\Controllers;

use App\Models\SuperAdminModel;
use Core\Schema;
use Symfony\Component\HttpFoundation\Request;
use Core\Controller;

class BackendController extends Controller
{
    public function Login(Request $request)
    {
        $headers = $request->headers->all();
        try {
            $userName = post("username");
            $password = post("password");

            $remember = post("remember");


            $superAdmin = SuperAdminModel::where('superadmin_name', $userName)->first();

            if ($superAdmin) {
                $passwordControl = passwodVerify($password, $superAdmin->superadmin_password);
                if ($passwordControl && $superAdmin->superadmin_status == 1) {
                    sesion()->create("superadmin_login", true);
                    sesion()->create("superadmin_id", $superAdmin->id);
                    sesion()->create("superadmin_name", $superAdmin->superadmin_name);


                    if ($remember) {
                        $rememberToken = createToken(['superadmin_id' => $superAdmin->id, 'token' => $superAdmin->superadmin_token]);
                        $expire = time() + 60 * 60 * 24;
                        setcookie("remember_superadmin_token", $rememberToken, time() + $expire, "/");
                    } else {
                        setcookie("remember_superadmin_token", "", time() - 3600, "/");
                    }

                    redirect(base_url());


                } else {
                    throw new \Exception("Kullanıcı adı veya şifre hatalı");
                }
            } else {
                throw new \Exception("Kullanıcı adı veya şifre hatalı");
            }

        } catch (\Exception $e) {
            controllerResponse($headers, $e->getMessage(), null, 'danger');
        }
    }

    public function Logout()
    {
        sesion()->remove('superadmin_login');
        sesion()->remove('superadmin_id');
        sesion()->remove('superadmin_name');
        setcookie("remember_superadmin_token", "", time() - 3600, "/");
        redirect(base_url('login'));
    }

    /**
     * @OA\Get(
     *   path="/app/get-filter-types",
     *   summary="Get filter types",
     *   tags={"Types"},
     *   @OA\Response(
     *     response=200,
     *     description="Filter Types Get Success"
     *   )
     * )
     */
    public function GetFilterTypes()
    {
        response([
            'status' => true,
            'message' => 'Filter Types Get Success',
            'data' => [
                '=', '!=', '>', '<', '>=', '<='
            ]
        ]);
    }

    /**
     * @OA\Get(
     *   path="/app/get-content-types",
     *   summary="Get content types",
     *   tags={"Types"},
     *   @OA\Response(
     *     response=200,
     *     description="Content Types Get Success"
     *   )
     * )
     */
    public function GetContentTypes()
    {
        $schema = new Schema();
        $fieldTypes = $schema->fieldTypes;

        response([
            'status' => true,
            'message' => 'Content Types Get Success',
            'data' => $fieldTypes
        ]);

    }


    /**
     * @OA\Get(
     *   path="/app/get-relation-types",
     *   summary="Get content types",
     *   tags={"Types"},
     *   @OA\Response(
     *     response=200,
     *     description="Content Types Get Success"
     *   )
     * )
     */
    public function GetRelationTypes()
    {

        response([
            'status' => true,
            'message' => 'Retation Types Get Success',
            'data' => ["oneToOne", "oneToMany", "manyToOne", "manyToMany"]
        ]);

    }


}


?>
