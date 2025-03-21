@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>System Logs</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="chart"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Detail Logs</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Level</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['latest_logs'] as $log)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $log->created_at }}</td>
                                    <td>{{ $log->level }}</td>
                                    <td>{{ Str::limit($log->message, 50) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var logsData = @json($data['logs']);
        var categories = Object.keys(logsData);
        var seriesData = [];

        var levels = Object.keys(logsData[categories[0]]);
        levels.forEach(function(level) {
            var data = categories.map(function(date) {
                return logsData[date][level];
            });
            seriesData.push({
                name: level,
                data: data
            });
        });

        var options = {
            chart: {
                type: 'line',
                height: 350
            },
            series: seriesData,
            xaxis: {
                categories: categories
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
</script>

<div id="chart"></div>
@endsection