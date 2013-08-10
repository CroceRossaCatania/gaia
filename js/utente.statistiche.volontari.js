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
  console.log(adesso);
  var meno17 = moment(adesso).subtract('years', 17).unix();
  console.log(meno17);
  var meno31 = moment(adesso).subtract('years', 31).unix();
  console.log(meno31);
  var meno44 = moment(adesso).subtract('years', 44).unix();
  console.log(meno44);
  var meno54 = moment(adesso).subtract('years', 54).unix();
  console.log(meno54);
  var meno64 = moment(adesso).subtract('years', 64).unix();
  console.log(meno64);

  for (var i = datesesso.length - 1; i >= 0; i--) {
    var data = datesesso[i]['data'];
    var sesso = datesesso[i]['sesso'];
    if (data > meno17) {
      sceglisesso(sesso, 0);
    } else if (data > meno31) {
      sceglisesso(sesso, 1);
    } else if (data > meno44) {
      sceglisesso(sesso, 2);
    } else if (data > meno54) {
      sceglisesso(sesso, 3);
    } else if (data > meno64) {
      sceglisesso(sesso, 4);
    } else {
      sceglisesso(sesso, 5);
    }
  }


  polyjs.chart({
    title: 'Volontari',
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
        y: { title: 'Maschi' }
    }
  });
  polyjs.chart({
    title: 'Volontari',
    dom: 'graficodx',
    layer: {
        data: polyjs.data({data: jsondata}),
        type: 'bar',
        x: 'età',
        y: 'femmine',
        tooltip: 'test',
        color: { const: 'pink' }
    },
    guide: {
        x: { title: 'Età' },
        y: { title: 'Femmine' }
    }
  });
}
