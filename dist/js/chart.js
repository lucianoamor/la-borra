var margin  = {top: 5, right: 10, bottom: 30, left: 40};
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
    d.date = format.parse(d.date);
});

var x = d3.time.scale()
   .domain(d3.extent(data, function(d) { return d.date; }))
   .range([radio, width - margin.right - margin.left]);

var max = d3.max(data, function(d) { return d.result; });
var upper = max + yExtra;
var y = d3.scale.linear()
    .domain([0, upper])
    .range([height - margin.top - margin.bottom, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .tickFormat(myFormatters.timeFormat("%d/%m"))
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
    return "<strong>" + d.result + "%</strong><br/>" + formatDateTip(d.date) + "<br/><em>" + d.pollster + "</em><br/>" + d.population;
})

svg.call(tip);

svg.selectAll()
    .data(data)
  .enter().append("circle")
    .attr("cx", function(d) { return x(d.date); })
    .attr("cy", function(d) { return y(d.result); })
    .attr("class", function(d) { return (d.pollster === "resultado") ? d.clase + " " + d.pollster : d.clase; })
    .attr("r", radio)
    .style("opacity", opacity)
    .style("fill", function(d) { return d.color })
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
    .attr("class", "axis")
    .attr("transform", "translate(0," + y.range()[0] + ")")
    .call(xAxis);

svg.append("g")
    .attr("class", "axis")
    .call(yAxis);

function tablaOver(clase) {
    d3.selectAll('.' + clase).attr("r", radio*2).classed("circleSelected", true);
};

$('.tabla tr')
    .on('mouseenter', function () {
        var clase = $(this).find('.img').attr('data-clase');
        tablaOver(clase);
    })
    .on('mouseleave', function () {
        d3.selectAll('.circleSelected').attr("r", radio).classed("circleSelected", false);
    });

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

$('.btn-ver-encuestas').click(function(event) {
    event.preventDefault();
    $(this).siblings('.hidden').removeClass('hidden');
    $(this).addClass('hidden');
});