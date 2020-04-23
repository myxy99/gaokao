<?php
/**
 * Created by PhpStorm.
 * User: myxy9
 * Date: 2020/4/21
 * Time: 15:58
 */

namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Project;
use App\Models\Province;
use App\Models\School;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function province(Request $request)
    {
        $q = $request->get('q');
        return (new Province())->where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }

    public function batch(Request $request)
    {
        $q = $request->get('q');
        return (new Batch())->where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }

    public function school(Request $request)
    {
        $q = $request->get('q');
        return (new School())->where('name', 'like', "%$q%")->paginate(null, ['code as id', 'name as text']);
    }

    public function project(Request $request)
    {
        $q = $request->get('q');
        return (new Project())->where('project_name', 'like', "%$q%")->paginate(null, ['id', 'project_name as text']);
    }
}