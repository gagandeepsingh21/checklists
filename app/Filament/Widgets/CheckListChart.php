<?php

namespace App\Filament\Widgets;

use App\Models\Checklist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CheckListChart extends ApexChartWidget
{
    use HasWidgetShield;

    public static function canView(): bool
    {
        return Gate::allows('widget_CheckListChart');
    }
    /**
     * Chart Id
     *
     * @var string
     */
    protected static string $chartId = 'checkListChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Checklist Requests';

    protected static bool $deferLoading = true;

    public ?string $filter = 'today';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $startDate = null;
        $endDate = now();

        switch ($this->filter) {
            case 'today':
                $startDate = now()->startOfDay();
                break;
            case 'week':
                $startDate = now()->subWeek()->startOfWeek();
                break;
            case 'month':
                $startDate = now()->subMonth()->startOfMonth();
                break;
            case 'year':
                $startDate = now()->startOfYear();
                break;
        }

        $completedRequests = DB::table('checklists')
            ->where('status', 'solved')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $pendingRequests = DB::table('checklists')
            ->where('status', 'pending')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return [
            'chart' => [
                'type' => 'pie',
                'height' => 300,
            ],
            'series' => [$completedRequests, $pendingRequests],
            'labels' => ['Solved'.' ' .'Requests', 'Pending'.' ' .'Requests'],
            'legend' => [
                'labels' => [
                    'colors' => '#9ca3af',
                    'fontWeight' => 600,
                ],
            ],
            'colors' => ['#00BFFF', '#FFA07A'], // blue for solved, orange for pending
            
        ];
    }
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
