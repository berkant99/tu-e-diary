$(document).ready(function () {
    var average = $('#average').text();
    var success = $('#students').text();
    var failed = $('#teachers').text();
    var disciplines = $('#specialties').text();

    var CountUpOptions = {
        useGrouping: false, // example: 1,000 vs 1000 (default: true)
        duration: 4 // animation duration in seconds (default: 2)
    }
    if (average != 0) {
        new countUp.CountUp('average', average, { startVal: 2.00, decimal: '.', useGrouping: false, decimalPlaces: 2, duration: 3 }).start();
    } else {
        $('#average').html("--");
    }
    new countUp.CountUp('students', success, CountUpOptions).start();
    new countUp.CountUp('teachers', failed, CountUpOptions).start();
    new countUp.CountUp('specialties', disciplines, CountUpOptions).start();

    const mainClr = '#175c93';

    const labels = [
        'ДЕПОС',
        'ДТК',
        'ЕФ',
        'КТУ',
        'КФ',
        'МТФ',
        'ФИТА'
    ];

    $.ajax({
        url: "serverControllers/getChartData.php",
        method: "GET",
        success: function (data) {
            var grades = [];
            var labels = [];
            var obj = JSON.parse(data);
            for (var i in obj) {
                grades.push(obj[i].average);
                labels.push(obj[i].faculty);
            }

            var chartData = {
                labels: labels,
                datasets: [{
                    label: 'Среден успех по факултети',
                    backgroundColor: mainClr,
                    borderColor: mainClr,
                    data: grades,
                    tension: 0.3
                }]
            };

            const lineConfig = {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    layout: {
                        padding: 5
                    },
                    animation: {
                        duration: 1500,
                        easing: 'linear'
                    },
                    transitions: {
                        show: {
                            animations: {
                                x: {
                                    from: 0
                                },
                                y: {
                                    from: 0
                                }
                            }
                        },
                        hide: {
                            animations: {
                                x: {
                                    to: 0
                                },
                                y: {
                                    to: 0
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 2,
                            max: 6,
                            title: {
                                display: true,
                                text: 'Среден успех'
                            }
                        },
                        x: {
                            ticks: {
                                maxTicksLimit: 7,
                                minTicksLimit: 7
                            },
                            title: {
                                display: true,
                                text: 'Факултети'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: mainClr,
                                boxWidth: 6,
                                boxHeight: 6,
                                font: {
                                    size: 16
                                }
                            }
                        }
                    }
                }
            };
            new Chart(document.getElementById('lineChart'), lineConfig);
        },
        error: function (data) {
            console.log(data);
        }
    });
});
