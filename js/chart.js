$(document).ready(function() {

    $('.filtros').on('change', '#from_date, #poblacion', function(event) {
        event.preventDefault();
        updateChart($('.form-filtros'));
        tablaResultados(idE);
        tablaEncuestas(idE);
    });

    $('.encuestas').on('click', '.enc-check', function(event) {
        event.preventDefault();
        var inp  = $(this).siblings('input'),
            icon = $(this).children('i'),
            tr   = $(this).parents('td');
        if(inp.is(':disabled')) {
            inp.prop('disabled', false);
            icon.removeClass().addClass('icon-check-empty');
            $(this).removeClass('btn-success').addClass('btn-default');
            tr.addClass('unchecked');
            // if($(this).hasClass('encs-check')) {
            //     // es padre
            //     var trH   = tr.nextUntil('tr.tr-encs'),
            //         btnH  = trH.find('.enc-check'),
            //         inpH  = btnH.siblings('input'),
            //         iconH = btnH.children('i');
            //     inpH.prop('disabled', false);
            //     iconH.removeClass().addClass('icon-check-empty');
            //     btnH.removeClass('btn-success').addClass('btn-default');
            //     trH.addClass('unchecked');
            // } else if(tr.nextUntil('tr.tr-encs').find('input:disabled').length + tr.prevUntil('tr.tr-encs').find('input:disabled').length === 0) {
            //     var trP   = tr.prevAll('tr.tr-encs').first(),
            //         btnP  = trP.find('.enc-check'),
            //         inpP  = btnP.siblings('input'),
            //         iconP = btnP.children('i');
            //     inpP.prop('disabled', false);
            //     iconP.removeClass().addClass('icon-check-empty');
            //     btnP.removeClass('btn-success').addClass('btn-default');
            //     trP.addClass('unchecked');
            // }
        } else {
            inp.prop('disabled', true);
            icon.removeClass().addClass('icon-check');
            $(this).removeClass('btn-default').addClass('btn-success');
            tr.removeClass('unchecked');
            // if($(this).hasClass('encs-check')) {
            //     // es padre
            //     var trH   = tr.nextUntil('tr.tr-encs'),
            //         btnH  = trH.find('.enc-check'),
            //         inpH  = btnH.siblings('input'),
            //         iconH = btnH.children('i');
            //     inpH.prop('disabled', true);
            //     iconH.removeClass().addClass('icon-check');
            //     btnH.removeClass('btn-default').addClass('btn-success');
            //     trH.removeClass('unchecked');
            // } else {
            //     var trP   = tr.prevAll('tr.tr-encs').first(),
            //         btnP  = trP.find('.enc-check'),
            //         inpP  = btnP.siblings('input'),
            //         iconP = btnP.children('i');
            //     inpP.prop('disabled', true);
            //     iconP.removeClass().addClass('icon-check');
            //     btnP.removeClass('btn-default').addClass('btn-success');
            //     trP.removeClass('unchecked');
            // }
        }
        tablaResultados(idE);
        updNEncuestas();
        updateChart($('.form-filtros'));
    });

    $('.btn-config').click(function(event) {
        event.preventDefault();
        $(this).siblings('.dropdown-menu').toggle();
    });
    $('#grado').change(function(event) {
        $(this).parents('.dropdown-menu').toggle();
        updateChart($('.form-filtros'));
    });
    $('#intervalos').click(function(event) {
        $(this).parents('.dropdown-menu').toggle();
        updateChart($('.form-filtros'));
    });

    $('.encuestas').on('click', '.btn-enc-todas', function(event) {
        event.preventDefault();
        if($('.enc-check').parent('td:not(".unchecked")').length === $('.enc-check').length) {
            return;
        }
        $('.enc-check').siblings('input').prop('disabled', true);
        $('.enc-check').children('i').removeClass().addClass('icon-check');
        $('.enc-check').removeClass('btn-default').addClass('btn-success');
        $('.enc-check').parent('td').removeClass('unchecked');
        tablaResultados(idE);
        updNEncuestas();
        updateChart($('.form-filtros'));
    });
    $('.encuestas').on('click', '.btn-enc-ninguna', function(event) {
        event.preventDefault();
        if($('.enc-check').parent('td.unchecked').length === $('.enc-check').length) {
            return;
        }
        $('.enc-check').siblings('input').prop('disabled', false);
        $('.enc-check').children('i').removeClass().addClass('icon-check-empty');
        $('.enc-check').removeClass('btn-success').addClass('btn-default');
        $('.enc-check').parent('td').addClass('unchecked');
        tablaResultados(idE);
        updNEncuestas();
        updateChart($('.form-filtros'));
    });

    $('.tabla-resultados')
    .on('mouseenter', 'tbody:first tr:not(".no-over")', function () {
        var clase = $(this).find('.img').attr('data-clase');
        tablaOver(clase);
        tablaResultadosOver(clase, $(this));
    })
    .on('mouseleave', 'tbody:first tr:not(".no-over")', function () {
        d3.selectAll('.circleSelected')
            .attr("r", radio)
            .classed("circleSelected", false);
        d3.selectAll('.lineSelected')
            .attr("stroke-width", stroke)
            .classed("lineSelected", false);
        d3.selectAll('.line')
            .style("opacity", 0);
    });

    $('.tabla-resultados').on('click', '.btn-hide-circles', function(event) {
        event.preventDefault();
        var cID  = $(this).attr('data-candidato'),
            icon = $(this).children('i');
        if(icon.hasClass('icon-check')) {
            icon.removeClass('icon-check').addClass('icon-check-empty');
            d3.selectAll('circle.c-' + cID + ':not(.resultado), .margen.c-' + cID)
                .classed("hidden", true);
        } else {
            icon.removeClass('icon-check-empty').addClass('icon-check');
            d3.selectAll('circle.c-' + cID + '.hidden, .margen.c-' + cID + '.hidden')
                .classed("hidden", false);
        }
    });

    $('.tabla-resultados').on('click', '.btn-hide-lines', function(event) {
        event.preventDefault();
        var cID  = $(this).attr('data-candidato'),
            icon = $(this).children('i');
        if(icon.hasClass('icon-check')) {
            icon.removeClass('icon-check').addClass('icon-check-empty');
            d3.selectAll('.line.c-' + cID)
                .classed("hidden", true);
        } else {
            icon.removeClass('icon-check-empty').addClass('icon-check');
            d3.selectAll('.line.c-' + cID + '.hidden')
                .classed("hidden", false);
        }
    });

    $('.encuestas')
    .on('mouseenter', 'td:not(".no-over")', function () {
        var clase = $(this).attr('data-clase');
        tablaOver(clase);
    })
    .on('mouseleave', 'td:not(".no-over")', function () {
        d3.selectAll('.circleSelected')
            .attr("r", radio)
            .attr("stroke-width", stroke)
            .classed("circleSelected", false);
    });

    // popovers
    // $('.tabla-resultados').popover({
    //     trigger: 'hover',
    //     html: true,
    //     selector: '.img'
    // });
    // $('.img').popover({
    //     trigger: 'hover',
    //     html   : true
    // });

    $('.tabla-head').tooltip({
        selector: '.tooltip-trigger',
        placement: 'bottom'
    });

    // simplebar
    $('.tabla-inner').simplebar();
    $(window).resize(function() {
        $('.tabla-inner').simplebar('recalculate');
    });

    // ini
    tablaResultados(idE);
    tablaEncuestas(idE);
    updateChart();
    $('.simplebar-scroll-content').animate({
        scrollTop: 0
    }, 1000);

});

function tablaResultados(idE) {
    $('.tabla-resultados tbody:first').html('<tr><td colspan="9" class="text-center"><i class="icon-spinner icon-spin icon-2x"></i></td></tr>');
    $.post('resultados.php', $('.form-filtros').serialize() + '&id=' + idE, function(data) {
        $('.tabla-resultados tbody:first').html(data.tabla);
    }, 'json');
}
function tablaEncuestas(idE) {
    $('.encuestas').html('<p class="text-center"><i class="icon-spinner icon-spin icon-2x"></i></p>');
    $.post('encuestas.php', $('.form-filtros').serialize() + '&id=' + idE, function(data) {
        $('.encuestas').html(data.tabla);
        updNEncuestas();
    }, 'json');
}
function updNEncuestas() {
    var n = 0;
    $('.encuestas td.encuestadora').not('.unchecked').each(function() {
        n += parseInt($(this).attr('data-nenc'), 10);
    });
    $('.nEnc').html(n);
}

// url > html5 browsers
if(location.search === '' && typeof history.replaceState !== 'undefined') {
    history.replaceState({}, '', location.protocol + '//' + location.host + location.pathname + idGet);
}

// d3
var margin  = {top: 5, right: 13, bottom: 25, left: 30};
    width   = 555,
    height  = 440,
    radio   = 4,
    yExtra  = 4,
    opacity = .75,
    stroke  = 2,
    format  = d3.time.format("%Y-%m-%d"),
    myFormatters = d3.locale({
        "decimal": ",",
        "thousands": ".",
        "grouping": [3],
        "currency": ["$", ""],
        "dateTime": "%a %b %e %X %Y",
        "date": "%d/%m/%Y",
        "time": "%H:%M:%S",
        "periods": ["AM", "PM"],
        "days": ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        "shortDays": ["D", "L", "Ma", "Mi", "J", "V", "S"],
        "months": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Deciembre"],
        "shortMonths": ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
    }),
    d3.helper = {};

data.forEach(function(d) {
    d.fecha = format.parse(d.fecha);
});

var x = d3.time.scale()
    .domain(d3.extent(data, function(d) { return d.fecha; }))
    .range([radio, width - margin.right - margin.left]);

var max = d3.max(data, function(d) { return d.resultado; });
var upper = max + yExtra;
var y = d3.scale.linear()
    .domain([0, upper])
    .range([height - margin.top - margin.bottom, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .tickFormat(myFormatters.timeFormat("%d/%m/%y"))
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .tickFormat(function(d) { return d + "%"; })
    .orient("left")
    .innerTickSize(-width);

var svg = d3.select("#borra").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var rect = svg.append("rect")
    .attr("width", width)
    .attr("height", height)
    .style("fill", "#fff")
    .attr("transform", "translate(-" + margin.top + ",-" + margin.left + ")");

var valueline = d3.svg.line()
    .x(function(d) { return x(d[0]); })
    .y(function(d) { return y(d[1]); });

// regresion
var dataL = data.length,
    candidatos = [];
for (var i = 0; i < dataL; i++) {
    if(candidatos.indexOf(data[i].candidatoId) === -1) {
        candidatos.push(data[i].candidatoId);
    }
}
var candidatosL = candidatos.length;
for (var i = 0; i < candidatosL; i++) {
    var dataCandidato = data.filter(function(d) {
        return d.candidatoId === candidatos[i] && d.esRes === 0;
    });
    dataCandidato = dataCandidato.sort(function(a, b) {
        return a["fecha"] - b["fecha"];
    });
    if(dataCandidato.length > 0) {
        var dataRegresion = [];
        dataCandidato.forEach(function(d) {
            dataRegresion.push([d.fecha.getTime(), d.resultado]);
        });
        var regresion = regression('polynomial', dataRegresion, 3).points;
        regresion.forEach(function(d) {
            d[0] = new Date(d[0]);
        });
        svg.append("path")
            .attr("d", valueline(regresion))
            .attr("class", "line c-" + dataCandidato[0].candidatoId)
            .attr("stroke", "#" + dataCandidato[0].color)
            .attr("stroke-width", stroke)
            .style("opacity", 0);
    }
}

svg.append("g")
    .attr("class", "axis xAxis")
    .attr("transform", "translate(0," + y.range()[0] + ")")
    .call(xAxis);

svg.append("g")
    .attr("class", "axis yAxis")
    .call(yAxis);

// funciones
function tablaOver(clase) {
    d3.selectAll('circle.' + clase)
        .attr("r", radio*1.6)
        .classed("circleSelected", true);
};
function tablaResultadosOver(clase, e) {
    d3.selectAll('.line.line-ok')
        .style("opacity", 1);
    d3.selectAll('.line.' + clase)
        .attr("stroke-width", stroke*2)
        .classed("lineSelected", true);
    d3.selectAll('.lastCircleSelected')
        .classed("lastCircleSelected", false);
    // tooltip
    $('.tt-intencion').html('<p class="candidato tbl-res" style="border-color: #' + e.attr('data-color') + ';">' + e.attr('data-candidato') + '</p><p class="agrupacion">' + e.attr('data-agrupacion') + '</p>');
    $('.tt-candidato').html('<p><img src="' + e.attr('data-imagen') + '" alt="' + e.attr('data-candidato') +'" /></p>');
    $('.tt-encuesta').html('<p class="subtit">Promedio</p><p class="intencion">' + e.attr('data-avg') + ' %</p><p class="subtit">Primero en</p><p class="intencion">' + e.attr('data-n1') + ' <span><br/>encuestas</span></p>');
};

var claseCandidatoLast = '';
function circleOver(t) {
    var item   = d3.select(t),
        clases = item.attr("class").split(' '),
        claseCandidato = clases.filter(function(d) {
            return d.indexOf('c-') > -1;
        }),
        claseEnc = clases.filter(function(d) {
            return d.indexOf('e-') > -1;
        }),
        claseEncs = clases.filter(function(d) {
            return d.indexOf('er-') > -1;
        });
    $('.img[data-clase="'+ claseCandidato[0] +'"]').parents('tr').addClass('hover');
    if(claseCandidato[0] !== claseCandidatoLast) {
        claseCandidatoLast = claseCandidato[0];
        $('.simplebar-scroll-content').prop({
            scrollTop: 0
        });
        $('.simplebar-scroll-content').animate({
            scrollTop: $('.img[data-clase="'+ claseCandidato[0] +'"]').position().top - 6
        }, 100);
    }
    $('.encuestas td.' + claseEncs[0] + ', .encuestas td.' + claseEnc[0]).addClass('hover');
    d3.selectAll('circle.' + claseCandidato[0])
        .attr("r", radio*1.6)
        .classed("circleSelected", true);
    d3.selectAll('circle')
        .classed("lastCircleSelected", false);
    d3.selectAll('.line.' + claseCandidato[0])
        .attr("stroke-width", stroke*2)
        .classed("lineSelected", true);
    item
        .attr("r", radio*2.2)
        .classed("lastCircleSelected", true)
        .style("opacity", 1);
}

function circleOut() {
    d3.selectAll('.circleSelected')
        .attr("r", radio)
        .style("opacity", opacity)
        .classed("circleSelected", false);
    d3.selectAll('.lineSelected')
        .attr("stroke-width", stroke)
        .classed("lineSelected", false);
    $('.img').parents('tr').removeClass('hover');
    $('.encuestas td').removeClass('hover');
}

function updateChart(filtros) {
    var dataFiltered = data,
        regGrado     = 3,
        mostrarInt   = 0;
    if(filtros) {
        var filtrosObj = filtros.serializeFormJSON();
        if(filtrosObj.poblacion !== '') {
            dataFiltered = dataFiltered.filter(function(d) {
                return d.poblacionId === filtrosObj.poblacion || d.esRes === 1;
            });
        }

        if(filtrosObj.from_date !== '0000-00-00') {
            dataFiltered = dataFiltered.filter(function(d) {
                return d.fecha >= Date.parse(filtrosObj.from_date) || d.esRes === 1;
            });
        }

        if(filtrosObj['encuestadoras[]']) {
            if(!Array.isArray(filtrosObj['encuestadoras[]'])) {
                var encuestadoras = [];
                encuestadoras[0] = filtrosObj['encuestadoras[]'];
            } else {
                var encuestadoras = filtrosObj['encuestadoras[]'];
            }
            dataFiltered = dataFiltered.filter(function(d) {
                if(d.esRes === 1) {
                    return true;
                }
                if(encuestadoras.indexOf(d.encuestadoraId) > -1) {
                    return false;
                } else {
                    return true;
                }
            });
        }

        if(filtrosObj.grado) {
            regGrado = parseInt(filtrosObj.grado, 10);
        }

        if(filtrosObj.intervalos) {
            mostrarInt = 1;
        }

        // if(filtrosObj['encuestas[]']) {
        //     if(!Array.isArray(filtrosObj['encuestas[]'])) {
        //         var encuestas = [];
        //         encuestas[0] = filtrosObj['encuestas[]'];
        //     } else {
        //         var encuestas = filtrosObj['encuestas[]'];
        //     }
        //     dataFiltered = dataFiltered.filter(function(d) {
        //         if(d.esRes === 1) {
        //             return true;
        //         }
        //         if(encuestas.indexOf(d.encuestaId) > -1) {
        //             return false;
        //         } else {
        //             return true;
        //         }
        //     });
        // }
    }

    var formatDateTip = d3.time.format("%d/%m/%Y"),
        ttRes;

    // ejes
    var interv = d3.time.month,
        nTicksX = interv.range(d3.min(dataFiltered, function(d) { return d.fecha; }), d3.max(dataFiltered, function(d) { return d.fecha; }), 1).length,
        step = Math.ceil(nTicksX / 10);
    if(nTicksX < 2) {
        interv = d3.time.week;
        nTicksX = interv.range(d3.min(dataFiltered, function(d) { return d.fecha; }), d3.max(dataFiltered, function(d) { return d.fecha; }), 1).length;
        step = 1;
        if(nTicksX === 0) {
            interv = d3.time.day;
        }
    }
    xAxis.ticks(interv, step);

    x.domain(d3.extent(dataFiltered, function(d) { return d.fecha; }));
    var max = d3.max(dataFiltered, function(d) { return d.resultado; });
    var upper = max + yExtra;
    y.domain([0, upper]);

    svg.select(".axis.xAxis").transition()
        .duration(750)
        .call(xAxis);
    svg.select(".axis.yAxis").transition()
        .duration(750)
        .call(yAxis);

    // circulos
    svg.selectAll("circle")
        .transition()
            .duration(750)
            .attr("r", 0)
            .style("opacity", 0)
            .remove();

    var ent = svg.selectAll()
        .data(dataFiltered)
      .enter();

    ent.append("circle")
        .attr("cx", function(d) { return x(d.fecha); })
        .attr("cy", function(d) { return y(d.resultado); })
        .attr("class", function(d) {
            var classes = 'c-' + d.candidatoId + ' p-' + d.poblacionId + ' e-' + d.encuestaId;
            if(d.encuestadora !== null) {
                classes += ' er-' + d.encuestadoraId;
            } else if(d.esRes === 1) {
                classes += ' resultado';
            }
            return classes;
        })
        .attr("r", 0)
        .style("opacity", 0)
        .style("fill", function(d) { return '#' + d.color })
        .on('mouseover', function(d) {
            circleOver(this, d);
            // tooltip
            d3.select('.tt-intencion').html('<p class="intencion" style="border-color: #' + d.color + ';">' + (ttRes = d.resultado.toString().replace(/\./g, ',')) + ' %</p><p class="candidato">' + d.candidato + '</p><p class="agrupacion">' + d.agrupacion + '</p>');
            d3.select('.tt-candidato').html('<p><img src="' + d.imagen + '" alt="' + d.candidato +'" /></p>');
            d3.select('.tt-encuesta').html('<p class="fecha">' + formatDateTip(d.fecha) + '</p><p class="encuestadora"><a href="' + d.fuente +'" target="_blank">' + ((d.esRes === 1) ? 'Resultado' : d.encuestadora) + '</a></p><p class="poblacion">' + ((d.esRes === 1) ? '' : d.poblacion) + '</p>');
        })
        .on('mouseout', function(d) {
            circleOut(this, d);
        })
        .transition()
            .duration(750)
            .style("opacity", opacity)
            .attr("r", radio);
    // intervalo de confianza
    svg.selectAll("rect.margen")
        .transition()
            .duration(750)
            .attr("height", 0)
            .style("opacity", 0)
            .remove();

    ent.append('rect')
        .attr("x", function(d) { return x(d.fecha); })
        .attr("y", function(d) {
            if(d.muestra > 0) {
                var margen = Math.sqrt(.96 / d.muestra) * 100;
                return y(d.resultado + margen);
            } else {
                return y(d.resultado);
            }
        })
        .attr("width", function(d) {
            if(d.muestra > 0) {
                return radio*2;
            } else {
                return 0;
            }
        })
        .attr("height", 0)
        .style("opacity", 0)
        .style("fill", function(d) { return '#' + d.color })
        .attr("transform", "translate(-" + radio + ",0)")
        .attr('class', function(d) { return 'c-' + d.candidatoId + ' margen'; })
      .transition()
        .duration(750)
        .style("opacity", mostrarInt)
        .attr("height", 1);

    ent.append('rect')
        .attr("x", function(d) { return x(d.fecha); })
        .attr("y", function(d) {
            if(d.muestra > 0) {
                var margen = Math.sqrt(.96 / d.muestra) * 100;
                return y(d.resultado - margen);
            } else {
                return y(d.resultado);
            }
        })
        .attr("width", function(d) {
            if(d.muestra > 0) {
                return radio*2;
            } else {
                return 0;
            }
        })
        .attr("height", 0)
        .style("opacity", 0)
        .style("fill", function(d) { return '#' + d.color })
        .attr("transform", "translate(-" + radio + ",0)")
        .attr('class', function(d) { return 'c-' + d.candidatoId + ' margen'; })
      .transition()
        .duration(750)
        .style("opacity", mostrarInt)
        .attr("height", 1);

    // regresion polinomial
    var dataL = dataFiltered.length,
        candidatos = [];
    for (var i = 0; i < dataL; i++) {
        if(candidatos.indexOf(dataFiltered[i].candidatoId) === -1 && dataFiltered[i].esRes === 0) {
            candidatos.push(dataFiltered[i].candidatoId);
        }
    }
    var dataL = data.length,
        candidatosTodos = [];
    for (var i = 0; i < dataL; i++) {
        if(candidatosTodos.indexOf(data[i].candidatoId) === -1) {
            candidatosTodos.push(data[i].candidatoId);
        }
    }
    var candidatosExit = candidatosTodos.filter(function(d) {
        return candidatos.indexOf(d) === -1 ;
    });
    var candidatosL = candidatos.length;
    for (var i = 0; i < candidatosL; i++) {
        var dataCandidato = dataFiltered.filter(function(d) {
            return d.candidatoId === candidatos[i] && d.esRes === 0;
        });
        dataCandidato = dataCandidato.sort(function(a, b) {
            return a["fecha"] - b["fecha"];
        });
        var dataRegresion = [];
        dataCandidato.forEach(function(d) {
            dataRegresion.push([d.fecha.getTime(), d.resultado]);
        });
        var regresion = regression('polynomial', dataRegresion, regGrado).points;
        regresion.forEach(function(d) {
            d[0] = new Date(d[0]);
        });
        if(dataCandidato.length === 0) {
            dataCandidato.push('');
            dataCandidato[0].candidatoId = '';
        }
        svg.select(".line.c-" + dataCandidato[0].candidatoId).transition()
            .duration(750)
                .attr("d", valueline(regresion));
        svg.select(".line.c-" + dataCandidato[0].candidatoId)
            .classed("line-ok", true);
    }
    var candidatosL = candidatosExit.length;
    for (var i = 0; i < candidatosL; i++) {
        svg.select(".line.c-" + candidatosExit[i]).transition()
            .duration(750)
                .style("opacity", 0);
        svg.select(".line.c-" + candidatosExit[i])
            .classed("line-ok", false);
    }
}

(function($) {
$.fn.serializeFormJSON = function() {
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};
})(jQuery);