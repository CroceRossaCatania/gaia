function volontari(datiComitato){
  var jsondata = [
  {"età": '14 - 17', maschi: 0, femmine: 0},
  {"età": '18 - 31', maschi: 0, femmine: 0},
  {"età": '32 - 44', maschi: 0, femmine: 0},
  {"età": '45 - 54', maschi: 0, femmine: 0},
  {"età": '55 - 64', maschi: 0, femmine: 0},
  {"età": '65+',     maschi: 0, femmine: 0}
  ];

  function sceglisesso(sesso, arpos) {
    switch (sesso) {
      case 'M': jsondata[arpos]['maschi']++;
                break;
      case 'F': jsondata[arpos]['femmine']++;
                break;
    };
  }

  var datesesso = datiComitato['datesesso'];

  var adesso = moment();
  var meno18 = moment(adesso).subtract('years', 18).unix();
  var meno32 = moment(adesso).subtract('years', 32).unix();
  var meno45 = moment(adesso).subtract('years', 45).unix();
  var meno55 = moment(adesso).subtract('years', 55).unix();
  var meno65 = moment(adesso).subtract('years', 65).unix();


  for (var i = datesesso.length - 1; i >= 0; i--) {
    var data = datesesso[i]['data'];
    var sesso = datesesso[i]['sesso'];
    if (data > meno18) {
      sceglisesso(sesso, 0);
    } else if (data > meno32) {
      sceglisesso(sesso, 1);
    } else if (data > meno45) {
      sceglisesso(sesso, 2);
    } else if (data > meno55) {
      sceglisesso(sesso, 3);
    } else if (data > meno65) {
      sceglisesso(sesso, 4);
    } else {
      sceglisesso(sesso, 5);
    }
  };


  polyjs.chart({
    title: 'Maschi',
    dom: 'graficosx',
    layer: {
        data: polyjs.data({data: jsondata}),
        type: 'bar',
        x: 'età',
        y: 'maschi',
        color: { const: 'blue' }
    },
    guide: {
        x: { title: 'Età' },
        y: { title: 'Numero Volontari' }
    }
  });
  polyjs.chart({
    title: 'Femmine',
    dom: 'graficodx',
    layer: {
        data: polyjs.data({data: jsondata}),
        type: 'bar',
        x: 'età',
        y: 'femmine',
        color: { const: 'pink' }
    },
    guide: {
        x: { title: 'Età' },
        y: { title: 'Numero Volontari' }
    }
  });

  var anzianita = datiComitato['anzianita'];
  for (var i = anzianita.length - 1; i >= 0; i--) {
    anzianita[i]['ingresso'] = moment.unix(parseInt(anzianita[i]['ingresso'])).format("YYYY");
  };

  polyjs.chart({
    title: 'Anni di ingresso dei volontari',
    dom: 'graficoanz',
    width: 800,
    layers: [{
        data: polyjs.data(anzianita, {'ingresso': { type: 'date', format: 'YYYY' }}),
        type: 'line',
        x: {'var': 'ingresso', 'sort': 'ingresso'},
        y: {'var': 'count(ingresso)'},
        color: 'sesso',
        size: {'const': 3}
    }, {
        data: polyjs.data(anzianita, {'ingresso': { type: 'date', format: 'YYYY' }}),
        type: 'point',
        x: {'var': 'ingresso', 'sort': 'ingresso'},
        y: {'var': 'count(ingresso)'},
        color: 'sesso',
        size: {'const': 3}
    } ],
    guide: {
        x: { title: 'Anno di ingresso' },
        y: { title: 'Volontari entrati' }
    }
  });
}
