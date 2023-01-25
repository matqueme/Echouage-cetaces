import ListeFetch from "./ListeFetch";
import ListeFetch2 from "./ListeFetch2";
import Graphics from './Graph'
import "./CSS/Liste.css"
import { useState, useEffect } from "react";


export const Liste = () => {

    //const de la input select qui sont mise dans param sous forme de tableau
    const [valueEspeceInput, setValueEspeceInput] = useState("1");
    const [valueDate1Input, setValueDate1Input] = useState(null);
    const [valueDate2Input, setValueDate2Input] = useState(null);

    //tableau des constants des paramètre mise dans un tableau
    const [param, setParam] = useState(["1", null, null]);

    //const de data de date et de espece de la bdd
    const [espece, setEspece] = useState(null);
    const [date, setDate] = useState(null);

    //lorsque l'on click sur valider
    function handleSubmit(e) {
        e.preventDefault();
        setParamTab();

    };

    //mettre les trois parametre dans un tab pour le passer en props
    function setParamTab() {
        let tab = [];
        tab.push(valueEspeceInput);
        tab.push(valueDate1Input);
        tab.push(valueDate2Input);
        setParam(tab);
    }


    //A chaque clique sur une nouvelle valeur on l'attribue a la variable correspondante
    function handleChangeEspece(e) {
        setValueEspeceInput(e.target.value);
    }
    //A chaque clique sur une nouvelle valeur on l'attribue a la variable correspondante
    function handleChangeDate1(e) {
        setValueDate1Input(e.target.value);
    }
    //A chaque clique sur une nouvelle valeur on l'attribue a la variable correspondante
    function handleChangeDate2(e) {
        setValueDate2Input(e.target.value);
    }


    //s'execute que 1 fois au lancement de la page
    useEffect(() => {

        getDataEspece();

        //Fonction async pour recuperer la liste des especes et des dates et la stocke dans la variable correspondante
        async function getDataEspece() {
            let [data, data2] = await Promise.all([
                fetch("http://127.0.0.1:8000/api/especes"),
                fetch("http://127.0.0.1:8000/api/dates")
            ]);
            let datedata = await data2.json();
            let especedata = await data.json();

            setEspece(especedata);
            setDate(datedata);
        }

    }, []);


    //return avec le HTML et le JS
    return (
        <div className="Content">
            <div className="trait_dessus"></div>
            <div className="formulaire">
                {/*A chaque validation du formulaire on lance handle submit */}

                <form onSubmit={handleSubmit}>
                    <div>
                        {/*Pour afficher les especes*/}
                        {espece && (
                            <select className="select" id="zone" onChange={handleChangeEspece} > {
                                espece.map((parametre) => (
                                    <ListeFetch2 data={parametre} />
                                ))
                            }</select>
                        )}

                        {/*Pour afficher les dates*/}
                        {date && (
                            <>
                                <select className="select" id="date1" onChange={handleChangeDate1}>{
                                    date.map((parametre) => (
                                        <ListeFetch data={parametre.date} />
                                    ))
                                }</select>


                                <select className="select" id="date2" defaultValue={date[date.length - 1].date} onChange={handleChangeDate2}>{
                                    date.map((parametre) => (
                                        <ListeFetch data={parametre.date} />
                                    ))
                                }</select>
                            </>
                        )}
                    </div><div>
                        <button type="submit" className="button"><span>Envoyer</span></button>
                    </div>
                </form>
            </div>
            <div className="trait_dessus"></div>

            {//Si espece, date et param ne sont pas vide on execute la fonction graphics
                (espece, date, param) &&
                <Graphics datas={param} />
            }


        </div >);
};

export default Liste;

