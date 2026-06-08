<div>
    <select id="post_by"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[20%] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        wire:model.live="postBy">
        <option value="days">Days</option>
        <option value="weeks">Weeks</option>
        <option value="year">Year</option>
    </select>
    {{-- @dump($bookings) --}}
    <div id="bookings_chart" wire:ignore></div>
    <script>
        document.addEventListener('livewire:initialized', function() {

            var options = {
                series: [{
                    name: 'Revenue per days',
                    data: @js($bookings['data'])
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: @js($bookings['date']),
                },
                yaxis: {
                    title: {
                        text: 'Revenue'
                    }
                },
                fill: {
                    opacity: 1,
                    colors: ['#000000']
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#bookings_chart"), options);
            chart.render();
            console.log(chart);
            

            Livewire.on('refresh-chart-data-bookings', (chartData) => {

                chart.updateOptions({
                    xaxis: {
                        categories: chartData[0].date
                    }
                });
                chart.updateSeries([{
                    data: chartData[0].data,
                }]);
            });

        })
    </script>
</div>

