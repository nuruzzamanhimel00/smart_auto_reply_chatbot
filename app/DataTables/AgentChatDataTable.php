<?php

namespace App\DataTables;

use PDF;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\AutoReplyRule;
use App\Traits\DataTableTrait;
use Yajra\DataTables\Html\Column;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Services\DataTable;

class AgentChatDataTable extends DataTable
{

    use DataTableTrait;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->filterColumn('agent_name', function ($query, $keyword) {
                $query->whereHas('agent', function ($q) use ($keyword) {
                    $q->where('first_name', 'like', "%{$keyword}%");
                });
            })
            ->editColumn('agent_name', function ($item) {
                return $item->agent ? $item->agent->first_name : 'Unassigned';
            })
            ->editColumn('auto_reply_enabled', function ($item) {
                return $item->auto_reply_enabled ? 'Yes' : 'No';
            })
            ->editColumn('status', function ($item) {
                $badge = $item->status == 'open' ? "bg-success" : "bg-danger";
                $status = $item->status == 'open' ? "Open" : "Closed";
                return '<span class="badge ' . $badge . '">' . $status . '</span>';
            })
            ->addColumn('action', function ($item) {
                $buttons = '';
                 $buttons .= '<li><a class="dropdown-item" href="' . route('agent.chat.chatBox', $item->uuid) . '" title="Show"><i class="fa fa-eye"></i> ' . __('Show') . '</a></li>';

                return '<div class="btn-group dropstart">
                              <button class="btn btn-secondary dropdown-toggle"  type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <ul class="dropdown-menu" role="menu" >
                              '. $buttons .'
                              </ul>
                        </div>';

            })

            ->editColumn('last_activity_at', function ($item) {
                return $item->last_activity_at ? $item->last_activity_at->diffForHumans() : '';
            })->rawColumns(['last_activity_at', 'action','status'])->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param Chat $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Chat $model)
    {
        return $model->newQuery()
        ->where('agent_id', auth()->id())
        ->orderBy('chats.id','desc')
        ->with(['agent', 'guest']);

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $params             = $this->getBuilderParameters();
        $params['order']    = [[2, 'asc']];

        $buttons = $this->getDynamicDataTableButtons(null,);

        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '55px', 'class' => 'text-center', 'printable' => false, 'exportable' => false, 'title' => 'Action'])
            ->parameters($params)
            ->buttons(...$buttons);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {

        $columns = [
            Column::computed('DT_RowIndex', __('SL')),
            Column::make('agent_name', 'agent_name')->title(__('Agent')),
            Column::make('guest.name', 'guest.name')->title(__('Guest')),
            Column::make('auto_reply_enabled', 'auto_reply_enabled')->title(__('Auto Reply Enabled')),
            Column::make('status', 'status')->title(__('Status')),
            Column::make('last_activity_at', 'last_activity_at')->title(__('Last Activity')),


        ];


        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'ChatManagement_' . date('YmdHis');
    }

    /**
     * pdf
     *
     * @return void
     */
    public function pdf()
    {
        $data = $this->getDataForExport();

        $pdf = PDF::loadView('vendor.datatables.print', [
            'data' => $data
        ]);
        return $pdf->download($this->getFilename() . '.pdf');
    }
}
