function getRGB(hex) {
  var hexNum = hex.replace('#', '');
  var hexValues = hexNum.match(/.{1,2}/g);

  for (var i = 0; i < hexValues.length; i++) {
    hexValues[i] = parseInt('0x' + hexValues[i], 16);
  }

  return hexValues;
}

function greatDiff(start, end) {
  var stColor = getRGB(start),
    enColor = getRGB(end),
    diff = 0;

  for (var i = 0; i < stColor.length; i++) {
    var calcDiff = Math.abs(stColor[i] - enColor[i]);

    if (calcDiff > diff) {
      diff = calcDiff;
    }
  }

  return diff;
}

function convertColor(start, end, step) {
  var startRGB = getRGB(start),
    endRGB = getRGB(end),
    result = "#";

  for (var i = 0; i < startRGB.length; i++) {
    var stNum = startRGB[i],
      enNum = endRGB[i];

    if (stNum != enNum) {
      if (stNum < enNum) {
        startRGB[i]++;
      } else if (stNum > enNum) {
        startRGB[i]--;
      }
    }

    var intVer = parseInt(startRGB[i], 10);
    if (intVer < 10) {
      result += '0' + intVer.toString(16);
    } else {
      result += (intVer.toString(16).length < 2 ? '0' + intVer.toString(16) : intVer.toString(16));
    }

  }

  return result;
}

class Counter {
  constructor(timer) {
    this.timer = timer;
    this.started = false;
    this.numStart = typeof this.timer.dataset.start != 'undefined' ? parseInt(this.timer.dataset.start) : 0;
    this.numEnd = parseInt(this.timer.dataset.finish);
    this.prepend = typeof this.timer.dataset.prepend != 'undefined' ? this.timer.dataset.prepend : '';
    this.append = typeof this.timer.dataset.append != 'undefined' ? this.timer.dataset.append : '';
    this.animateNum = typeof this.timer.dataset.countanim != 'undefined' ? this.timer.dataset.countanim : true;
    this.count = this.numStart;
    this.speed = typeof this.timer.dataset.speed != 'undefined' ? parseInt(this.timer.dataset.speed) : 100;
    this.increment = typeof this.timer.dataset.increment != 'undefined' ? parseInt(this.timer.dataset.increment) : 0;

    this.displayLoop();
  }

  displayLoop() {
    let _this = this;
    this.started = true;

    if (this.animateNum == true) {
      this.timer.querySelector('.display').innerHTML = `<span class="decorator prepend">${this.prepend}</span><span class="count">${this.count}</span><span class="decorator append">${this.append}</span>`
    }

    if (this.count < this.numEnd) {
      this.loop = setTimeout(function() {
        _this.displayLoop();
      }, this.speed);
      if (this.increment > 0 && this.numEnd - this.count > this.increment) {
        this.count += this.increment;
      } else {
        this.count++;
      }
    }
  }

  prependCanvas(canvas) {
    var firstChild = this.timer.firstChild;
    this.timer.insertBefore(canvas, firstChild);
  }

  getTimer() {
    return this.timer;
  }

  getCount() {
    return this.count;
  }

  getTotal() {
    return this.numEnd;
  }

  getStarted() {
    return this.started;
  }
}

class Radial extends Counter {
  constructor(timer) {
    super(timer);

    var _timer = super.getTimer();
    this.cClockwise = typeof _timer.dataset.cclockwise != 'undefined' ? this.timer.dataset.cclockwise : false;

    var pixelRatio = window.devicePixelRatio || 1;

    var canvas = document.createElement('canvas');
    canvas.setAttribute('class', 'progress-bar');
    canvas.setAttribute('width', '300');
    canvas.setAttribute('height', '210');
    super.prependCanvas(canvas);

    // Radial bar
    this.radialBar = _timer.querySelector('.progress-bar');
    this.radialBar.style.width = this.radialBar.width + 'px';
    this.radialBar.style.height = this.radialBar.height + 'px';
    this.radialBar.width *= pixelRatio;
    this.radialBar.height *= pixelRatio;

    this.radialColor = typeof _timer.dataset.color != 'undefined' ? this.timer.dataset.color : '#000';
    this.startColor = this.radialColor;
    this.endColor = typeof _timer.dataset.endcolor != 'undefined' ? this.timer.dataset.endcolor : this.radialColor;

    this.xPos = this.radialBar.width / 2 / pixelRatio;
    this.yPos = this.radialBar.height / 2 / pixelRatio + 10;

    this.radialProgress = this.radialBar.getContext('2d');
    this.radialProgress.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);
    this.setStage();

    this.displayLoop();
  }

  setStage() {
    var radius = 98;
    var startAngle = .75 * Math.PI;
    var endAngle = 2.25 * Math.PI;
    var counterClock = false;

    // Set position and width
    this.radialProgress.beginPath();
    this.radialProgress.arc(this.xPos, this.yPos, radius, startAngle, endAngle, counterClock);
    this.radialProgress.lineWidth = 50;

    // line color
    this.radialProgress.strokeStyle = '#444';
    // this.radialProgress.lineCap = 'butt';
    this.radialProgress.stroke();
  }

  drawProgress(percent) {
    var radius = 98;
    if (this.cClockwise) {
      var startAngle = 2.25 * Math.PI;
      var position = (percent * (.75 - 2.25) / 100) + 2.25;
      var endAngle = (position >= .75 ? position : .75) * Math.PI;
    } else {
      var startAngle = .75 * Math.PI;
      var position = (percent * (2.25 - .75) / 100) + .75;
      var endAngle = (position <= 2.25 ? position : 2.25) * Math.PI;
    }

    this.radialProgress.beginPath();
    this.radialProgress.arc(this.xPos, this.yPos, radius, startAngle, endAngle, this.cClockwise);
    this.radialProgress.lineWidth = 40;
    // this.radialProgress.lineCap = 'round';

    // line color
    if (this.radialColor == this.endColor) {
      this.radialProgress.strokeStyle = this.radialColor;
    } else {
      this.startColor = convertColor(this.startColor, this.endColor, percent);
      this.radialProgress.strokeStyle = this.startColor;
    }
    this.radialProgress.stroke();
  }

  displayLoop() {
    var _started = super.getStarted();
    super.displayLoop();

    var _count = super.getCount();

    if (typeof this.radialProgress != "undefined") {
      this.radialProgress.clearRect(0, 0, this.radialBar.width, this.radialBar.height);
      this.setStage();
      this.drawProgress(_count);
    }
  }
}

class Grid extends Counter {
  constructor(timer) {
    super(timer);

    var _timer = super.getTimer();

    this.dotGrid = _timer.querySelector('.grid');
    for (let i = 0; i < 100; ++i) {
      let span = document.createElement('span');
      span.setAttribute('class', 'dot');
      this.dotGrid.append(span);
    }
    this.dots = this.dotGrid.querySelectorAll('.dot');
    this.displayLoop();
  }

  gridProgress(position) {
    if (typeof this.dots !== 'undefined') {
      this.dots[0].setAttribute('class', 'active');
      this.dots[position - 1].setAttribute('class', 'active');
    }
  }

  displayLoop() {
    super.displayLoop();

    var _count = super.getCount();
    this.gridProgress(_count);
  }
}

var counters = [],
  counterBlocks = document.querySelectorAll('.js-counter');
for (let i = 0; i < counterBlocks.length; ++i) {
  counters[i] = new Counter(counterBlocks[i]);
}

var radials = [],
  radialBlocks = document.querySelectorAll('.js-radial');
for (let i = 0; i < radialBlocks.length; i++) {
  radials[i] = new Radial(radialBlocks[i]);
}

var grids = [],
  gridBlocks = document.querySelectorAll('.js-grid');
for (let i = 0; i < gridBlocks.length; i++) {
  grids[i] = new Grid(gridBlocks[i]);
}


$(function(){
  var actualizarHora = function(){
    var fecha = new Date(),
        hora = fecha.getHours(),
        minutos = fecha.getMinutes(),
        segundos = fecha.getSeconds(),
        diaSemana = fecha.getDay(),
        dia = fecha.getDate(),
        mes = fecha.getMonth(),
        anio = fecha.getFullYear(),
        ampm;
    
    var $pHoras = $("#horas"),
        $pSegundos = $("#segundos"),
        $pMinutos = $("#minutos"),
        $pAMPM = $("#ampm"),
        $pDiaSemana = $("#diaSemana"),
        $pDia = $("#dia"),
        $pMes = $("#mes"),
        $pAnio = $("#anio");
    var semana = ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'];
    var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    
    $pDiaSemana.text(semana[diaSemana]);
    $pDia.text(dia);
    $pMes.text(meses[mes]);
    $pAnio.text(anio);
    if(hora>=12){
      hora = hora - 12;
      ampm = "PM";
    }else{
      ampm = "AM";
    }
    if(hora == 0){
      hora = 12;
    }
    if(hora<10){$pHoras.text("0"+hora)}else{$pHoras.text(hora)};
    if(minutos<10){$pMinutos.text("0"+minutos)}else{$pMinutos.text(minutos)};
    if(segundos<10){$pSegundos.text("0"+segundos)}else{$pSegundos.text(segundos)};
    $pAMPM.text(ampm);
    
  };
  
  
  actualizarHora();
  var intervalo = setInterval(actualizarHora,1000);
});