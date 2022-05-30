$(document).ready(function () {
    var average = $('#average').text();
    var success = $('#s-exams').text();
    var failed = $('#f-exams').text();
    var disciplines = $('#u-disciplines').text();
    var stream = $('#stream').text();
    var university = $('#university').text();

    var CountUpOptions = {
        useGrouping: false, // example: 1,000 vs 1000 (default: true)
        duration: 4 // animation duration in seconds (default: 2)
    }
    if (average != 0) {
        new countUp.CountUp('average', average, { startVal: 2.00, decimal: '.', useGrouping: false, decimalPlaces: 2, duration: 3 }).start();
    } else {
        $('#average').html("--");
    }
    new countUp.CountUp('s-exams', success, CountUpOptions).start();
    new countUp.CountUp('f-exams', failed, CountUpOptions).start();
    new countUp.CountUp('u-disciplines', disciplines, CountUpOptions).start();
    new countUp.CountUp('stream', stream, CountUpOptions).start();
    new countUp.CountUp('university', university, CountUpOptions).start();

    const mainClr = '#175c93';

    const labels = [
        'I',
        'II',
        'III',
        'IV',
        'V',
        'VI',
        'VII',
        'VIII'
    ];

    $.ajax({
        url: "serverControllers/getChartData.php",
        method: "GET",
        success: function (data) {
            var grades = [];
            var obj = JSON.parse(data);
            for (var i in obj) {
                grades.push(obj[i].average);
            }

            var chartData = {
                labels: labels,
                datasets: [{
                    label: 'Среден успех по семестри',
                    backgroundColor: mainClr,
                    borderColor: mainClr,
                    data: grades,
                    tension: 0.3
                }]
            };

            const lineConfig = {
                type: 'line',
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
                                maxTicksLimit: 10,
                                minTicksLimit: 4
                            },
                            title: {
                                display: true,
                                text: 'Семестри'
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
