$(document).ready(function() {

    $('#from_date, #poblacion').change(function(event) {
        event.preventDefault();
        tablaResultados(idE);
        tablaEncuestas(idE);
    });

    $('.encuestas').on('click', '.enc-check', function(event) {
        event.preventDefault();
        var inp  = $(this).siblings('input'),
            icon = $(this).children('i'),
            tr   = $(this).parents('tr');
        if(inp.is(':disabled')) {
            inp.prop('disabled', false);
            icon.removeClass().addClass('icon-check-empty');
            $(this).removeClass('btn-success').addClass('btn-default');
            tr.addClass('unchecked');
            if($(this).hasClass('encs-check')) {
                // es padre
                var trH   = tr.nextUntil('tr.tr-encs'),
                    btnH  = trH.find('.enc-check'),
                    inpH  = btnH.siblings('input'),
                    iconH = btnH.children('i');
                inpH.prop('disabled', false);
                iconH.removeClass().addClass('icon-check-empty');
                btnH.removeClass('btn-success').addClass('btn-default');
                trH.addClass('unchecked');
            }
        } else {
            inp.prop('disabled', true);
            icon.removeClass().addClass('icon-check');
            $(this).removeClass('btn-default').addClass('btn-success');
            tr.removeClass('unchecked');
            if($(this).hasClass('encs-check')) {
                // es padre
                var trH   = tr.nextUntil('tr.tr-encs'),
                    btnH  = trH.find('.enc-check'),
                    inpH  = btnH.siblings('input'),
                    iconH = btnH.children('i');
                inpH.prop('disabled', true);
                iconH.removeClass().addClass('icon-check');
                btnH.removeClass('btn-default').addClass('btn-success');
                trH.removeClass('unchecked');
            } else {
                var trP   = tr.prevAll('tr.tr-encs').first(),
                    btnP  = trP.find('.enc-check'),
                    inpP  = btnP.siblings('input'),
                    iconP = btnP.children('i');
                inpP.prop('disabled', true);
                iconP.removeClass().addClass('icon-check');
                btnP.removeClass('btn-default').addClass('btn-success');
                trP.removeClass('unchecked');
            }
        }
        tablaResultados(idE);
        updNEncuestas();
    });

    $('.tabla-resultados')
    .on('mouseenter', 'tbody:first tr', function () {
        var clase = $(this).find('.img').attr('data-clase');
        tablaOver(clase);
    })
    .on('mouseleave', 'tbody:first tr', function () {
        d3.selectAll('.circleSelected').attr("r", radio).classed("circleSelected", false);
    });

    // popovers
    $('.tabla-resultados').popover({
        trigger: 'hover',
        html: true,
        selector: '.img'
    });

    // ini
    tablaResultados(idE);
    tablaEncuestas(idE);

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
    }, 'json');
}
function updNEncuestas() {
    $('.nEnc').html($('input[name="encuestas[]"]:disabled').length);
}

// url > html5 browsers
if(location.search === '' && typeof history.replaceState !== 'undefined') {
    history.replaceState({}, '', location.protocol + '//' + location.host + location.pathname + idGet);
}

// d3
var margin  = {top: 5, right: 10, bottom: 60, left: 40};
    width   = 670,
    height  = 550,
    radio   = 4,
    yExtra  = 0,
    opacity = .75,
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
    .tickFormat(myFormatters.timeFormat("%d/%m/%Y"))
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .tickFormat(function(d) { return d + "%"; })
    .ticks(21) // cada 5
    .orient("left");

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

var formatDateTip = d3.time.format("%d/%m/%Y");

var tip = d3.tip()
  .attr('class', 'd3-tip')
  .offset([-10, 0])
  .html(function(d) {
    var t = '<strong>' + d.resultado + '%</strong>' + "<br/>";
    if(d.esRes === 0) {
        t += formatDateTip(d.fecha) + "<br/><em>" + d.encuestadora + "</em><br/>" + d.poblacion;
    } else {
        t += "<em>" + "Resultado" + "</em>";
    }
    return t;
})

svg.call(tip);

svg.selectAll()
    .data(data)
  .enter().append("circle")
    .attr("cx", function(d) { return x(d.fecha); })
    .attr("cy", function(d) { return y(d.resultado); })
    .attr("class", function(d) {
        var classes = 'c-' + d.candidatoId + ' p-' + d.poblacionId + 'e-' + d.encuestaId;
        if(d.encuestadora !== null) {
            classes += ' er-' + d.encuestadoraId;
        } else if(d.esRes === 1) {
            classes += ' resultado';
        }
        return classes;
    })
    .attr("r", radio)
    .style("opacity", opacity)
    .style("fill", function(d) { return '#'+d.color })
    .on('mouseover', function(d) {
        tip.show(d);
        circleOver(this, d);
    })
    .on('mouseout', function(d) {
        tip.hide(d);
        circleOut(this, d);
    });

// d3.selectAll('.resultado')
//     .attr("r", radio*2);

svg.append("g")
    .attr("class", "axis xAxis")
    .attr("transform", "translate(0," + y.range()[0] + ")")
    .call(xAxis)
    .selectAll("text")
        .style("text-anchor", "end")
        .attr("dx", "-.8em")
        .attr("dy", ".15em")
        .attr("transform", "rotate(-45)");

svg.append("g")
    .attr("class", "axis")
    .call(yAxis);

function tablaOver(clase) {
    d3.selectAll('.' + clase).attr("r", radio*2).classed("circleSelected", true);
};

function circleOver(t) {
    var item = d3.select(t),
        clase = item.attr("class");
    $('.img[data-clase="'+ clase +'"]').parents('tr').addClass('hover');
    d3.select(t).attr("r", radio*2).classed("circleSelected", true);
}

function circleOut() {
    d3.selectAll('.circleSelected').attr("r", radio).classed("circleSelected", false);
    $('.img').parents('tr').removeClass('hover');
}