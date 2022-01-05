<?php

namespace App\Http\Controllers;

use App\SellTarget;
use App\User;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SellTargetController extends Controller
{

    /**
     * All Utils instance.
     *
     */
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('roles.view') && !auth()->user()->can('roles.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $sell_target = SellTarget::join('users', 'sell_targets.user_id', 'users.id')
                ->where('sell_targets.business_id', $business_id)
                ->select(['target', 'users.first_name as first_name','note', 'sell_targets.id as id']);

            return DataTables::of($sell_target)
                ->addColumn(
                    'action',
                    '@can("role.update")
                    <button data-href="{{action(\'SellTargetController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_target_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                    @endcan
                    @can("role.delete")
                        <button data-href="{{action(\'SellTargetController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_target_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan'
                )
                ->removeColumn('id')
                ->rawColumns([3])
                ->make(false);
        }

        return view('sell_target.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('brand.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');

        $quick_add = false;
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }

        $users = User::role('MPO' . '#' . $business_id)->pluck('first_name', 'id')->toArray();

        $is_repair_installed = $this->moduleUtil->isModuleInstalled('Repair');
        return view('sell_target.create')
            ->with(compact('quick_add', 'is_repair_installed', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('role.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $input = $request->only(['target', 'note', 'user_id']);
            $business_id = $request->session()->get('user.business_id');
            $input['business_id'] = $business_id;
            // $input['created_by'] = $request->session()->get('user.id');

            // if ($this->moduleUtil->isModuleInstalled('Repair')) {
            //     $input['use_for_repair'] = !empty($request->input('use_for_repair')) ? 1 : 0;
            // }

            $target = SellTarget::create($input);
            $output = [
                'success' => true,
                'data' => $target,
                'msg' => __("Target Added Successfully")
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => false,
                'msg' => __("messages.something_went_wrong")
            ];
        }

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SellTarget  $sellTarget
     * @return \Illuminate\Http\Response
     */
    public function show(SellTarget $sellTarget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SellTarget  $sellTarget
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('role.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $sell_target = SellTarget::where('business_id', $business_id)->find($id);

            $is_repair_installed = $this->moduleUtil->isModuleInstalled('Repair');
            $users = User::role('MPO' . '#' . $business_id)->pluck('first_name', 'id')->toArray();
            return view('sell_target.edit')
                ->with(compact('sell_target', 'is_repair_installed','users'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SellTarget  $sellTarget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if (!auth()->user()->can('role.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['target', 'note','user_id']);
                $business_id = $request->session()->get('user.business_id');

                $sell_target = SellTarget::where('business_id', $business_id)->findOrFail($id);
                $sell_target->target = $input['target'];
                $sell_target->user_id = $input['user_id'];
                $sell_target->note = $input['note'];

                // if ($this->moduleUtil->isModuleInstalled('Repair')) {
                //     $sell_target->use_for_repair = !empty($request->input('use_for_repair')) ? 1 : 0;
                // }
                
                $sell_target->save();

                $output = ['success' => true,
                            'msg' => __("Sell Target Updated Successfully")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return $output;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SellTarget  $sellTarget
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('role.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->user()->business_id;

                $area = SellTarget::where('business_id', $business_id)->findOrFail($id);
                $area->delete();

                $output = ['success' => true,
                            'msg' => __("Sell Target Deleted Successfully")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return $output;
        }
    }
}
