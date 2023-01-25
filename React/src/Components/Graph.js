import React from 'react';
import { useState, useEffect } from "react";

import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from 'chart.js';

import { Bar } from 'react-chartjs-2';


ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

export let options = {
    responsive: true,
    plugins: {
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: 'Echouage',
        },
    }, scales: {
        x: {  // <-- axis is not array anymore, unlike before in v2.x: '[{'
            grid: {
                color: 'rgba(255,255,255,0.2)',
                borderColor: '#ffffff'
            }
        },
        y: {  // <-- axis is not array anymore, unlike before in v2.x: '[{'
            grid: {
                color: 'rgba(255,255,255,0.2)',
                borderColor: '#ffffff'
            }
        }
    }
};

//let labels = ['January', 'February', 'March', 'April', 'May', 'June'];





function App(props) {


    const [data, setData] = useState(null);
    const [param, setParam] = useState(false);

    //se lance a chaque affichage
    useEffect(() => {

        getDataZones();

        //Fonction async pour recuperer les zones et les mettre dans le const zones
        async function getDataZones() {
            const response = await fetch("http://127.0.0.1:8000/api/zones");
            const zonesdata = await response.json();

            const response2 = await fetch("http://127.0.0.1:8000/api/dates");
            const datesdata = await response2.json();


            //variable temporaire, sinon le temps d'affecter les valeurs dans les const la variable est null en retour
            let datestarttemp, dateendtemp, especetemp;

            //boucle affectation des date de debut et de fin
            if (props.datas[1] === null) {
                datestarttemp = datesdata[0].date;

            } else {
                datestarttemp = props.datas[1];
            }

            if (props.datas[2] === null) {
                dateendtemp = datesdata[datesdata.length - 1].date;
            } else {
                dateendtemp = props.datas[2];
            }

            especetemp = props.datas[0];

            // requete pour le graph
            const response3 = await fetch("http://127.0.0.1:8000/api/echouages/" + datestarttemp + "/" + dateendtemp + "/" + especetemp);
            const echouagesdata = await response3.json();


            // fonction pour data
            setdatasets(zonesdata, datestarttemp, dateendtemp, echouagesdata);
        }
    }, [props]);


    function setdatasets(zonesdata, datestart, dateend, echouagesdata) {

        let datasets = [];

        //Date for labls 
        let labels = [];
        for (var i = datestart; i <= dateend; i++) (
            labels.push(i)
        )
        /*
        datesdata.map((e) => {
            labels.push(e.date)
        });*/

        let zone = [];
        zonesdata.map((e) => (
            zone.push(e.zone)
        ));


        let echouagenombre = [];
        for (let i = 1; i <= zone.length; i++) {
            let tab = [];

            for (let j = datestart; j <= dateend; j++) {
                echouagesdata.forEach((e) => {
                    if ((e.date === j) && (e.zone_id === i)) {
                        tab.push(e.nombre);
                    }
                });
                if (tab.length <= j - datestart)
                    tab.push(0)

            }
            echouagenombre.push(tab);
        }





        let backgroundColorCONST = ['rgba(205, 6, 103, 0.8)', 'rgba(125, 39, 143, 0.8)', 'rgba(2, 158, 219, 0.8)', 'rgba(103, 167, 65, 0.8)',]

        for (let i = 0; i < zone.length; i++) {
            let label = zone[i]
            let backgroundColor = backgroundColorCONST[i % 4]
            let data = echouagenombre[i]
            //console.log(echouagenombre[i])

            datasets.push({
                label,
                backgroundColor,
                borderRadius: 10,
                borderSkipped: false,
                data,

            })

        }

        let data2 = {
            labels,
            datasets
        };
        setData(data2)
        setParam(true);

    }

    return (
        <div id="graph">

            {param && (

                < div style={{ position: "relative", width: "60vw", margin: "auto" }}>
                    <Bar options={options} data={data} />
                </div>
            )
            }
        </div >
    );
};

export default App;

/*
export default class Graph extends React.Component {

    render() {
        return (
            <div style={{ position: "relative", width: "60vw", margin: "auto" }}>
                <Bar ref="chart" options={options} data={data} />
            </div>
        );
    }

};*/

