function volontari(){
  var jsondata = [
  {cat: '14 - 17', male: 12, female: 15},
  {cat: '18 - 31', male: 18, female: 21},
  {cat: '32 - 44', male: 24, female: 29},
  {cat: '45 - 54', male: 22, female: 25},
  {cat: '55 - 64', male: 13, female: 19},
  {cat: '65+', male: 10, female: 13}
  ];

  var jsondata2 = [
  {cat: '14 - 17', male: 12},
  {cat: '18 - 31', male: 18},
  {cat: '32 - 44', male: 24},
  {cat: '45 - 54', male: 22},
  {cat: '55 - 64', male: 13},
  {cat: '65+', male: 10}
  ];

  polyjs.chart({
    title: 'Volontari',
    dom: 'grafico',
    width: 720,
    layer: {
        data: polyjs.data({data: jsondata2}),
        type: 'bar',
        x: 'cat',
        y: 'male',
        color: { const: 'darkgreen' }
    }
  });
}
