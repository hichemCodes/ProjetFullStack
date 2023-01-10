import React, { useEffect } from 'react'
import '../styles/loader.css'


const HorrairesDouverture = ({changeHorrairesDeOuverture,boutiqueUpdate}) => {

    let horaires_de_ouvertureValue =  [];

    const days = ["lundi","mardi","mercredi","jeudi","vendredi","samedi","dimanche"];

    const genererHorarireFromInputs = () => {
        horaires_de_ouvertureValue =  [];
        const divsInputs = document.querySelectorAll(".jour");
        divsInputs.forEach((div,index) => {
            let matinApresMidi = div.querySelectorAll("input");
            let matinStart = (matinApresMidi[0].value == "") ? "fermé" : `${matinApresMidi[0].value}h`;
            let matinEnd = '';
            if(matinStart == 'fermé') {
                matinEnd = '';
            } else {
                matinEnd = (matinApresMidi[1].value == "") ? "fermé" : `-${matinApresMidi[1].value}h`;
            }
            let ApresMidiStart = (matinApresMidi[2].value == "") ? "fermé" : `${matinApresMidi[2].value}h`;
            let ApresMidiEnd = '';
            if(ApresMidiStart == 'fermé') {
               ApresMidiEnd = '';

            } else {
               ApresMidiEnd = (matinApresMidi[3].value == "") ? "fermé" : `-${matinApresMidi[3].value}h`;

            }
            
            let jourObject = {
                [days[index]] : {
                    "matin": `${matinStart}${matinEnd}`,
                    "apreMidi": `${ApresMidiStart}${ApresMidiEnd}`
                }
            };
            horaires_de_ouvertureValue.push(jourObject);

        });
        changeHorrairesDeOuverture(horaires_de_ouvertureValue);
        console.log(horaires_de_ouvertureValue);
    }


    const updateHorraires = () => {
        let horaires_de_ouverture_initialse;
        
        if(boutiqueUpdate.length == 0) {
            horaires_de_ouverture_initialse = [{"lundi":{"matin":"08:00h-12:00h","apreMidi":"14:00h-18:00h"}},{"mardi":{"matin":"08:00h-12:00h","apreMidi":"14:00h-20:00h"}},{"mercredi":{"matin":"08:00h-12:00h","apreMidi":"14:00h-20:00h"}},{"jeudi":{"matin":"08:00h-12:00h","apreMidi":"14:00h-20:00h"}},{"vendredi":{"matin":"08:00h-12:00h","apreMidi":"14:00h-20:00h"}},{"samedi":{"matin":"08:00h-12:00h","apreMidi":"14:00h-20:00h"}},{"dimanchhe":{"matin":"08:00h-12:00h","apreMidi":"14:00h-20:00h"}}];
        } else {
            horaires_de_ouverture_initialse = boutiqueUpdate.horairesDeOuverture;
        }
        
        const divsInputs = document.querySelectorAll(".jour");
        divsInputs.forEach((div,index) => {
            
            let matinApresMidi = div.querySelectorAll("input");
            let currentObj = horaires_de_ouverture_initialse[index];
            let currentObjElemnts = currentObj[Object.keys(currentObj)[0]];

            let allMatin = currentObjElemnts.matin;
            let allApresMidi = currentObjElemnts.apreMidi;
            if(allMatin == "fermé") {
                matinApresMidi[0].value = '';
                matinApresMidi[1].value = '';
            }
            else {
                let allMatinHeure = allMatin.split("-");
                let matinStart = allMatinHeure[0].slice(0,-1);//donne 8:56 par exmpele 
                let matinEnd = allMatinHeure[1].slice(0,-1);
               
                matinApresMidi[0].value = matinStart;
                matinApresMidi[1].value = matinEnd;
                
            }
            if(allApresMidi == "fermé") {
                matinApresMidi[2].value = '';
                matinApresMidi[3].value = '';
            } else {
                let allApresMidiHeure = allApresMidi.split("-");
                let apresMidiStart = allApresMidiHeure[0].slice(0,-1);//donne 8:56 par exmpele 
                let apresMidiEnd = allApresMidiHeure[1].slice(0,-1);
               
                matinApresMidi[2].value = apresMidiStart;
                matinApresMidi[3].value = apresMidiEnd;
            }

            changeHorrairesDeOuverture(horaires_de_ouverture_initialse);

        });
       
    }



    useEffect( () =>{
        
        updateHorraires();
        
    },[boutiqueUpdate]);
    

    return (
        <div class="horaires_components">
                <table>
                    <tr>
                        <td>lundi</td>
                        <div className='jour'>
                            <span>Matin</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            </td>
                            <span>Après midi</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            
                            </td>
                        </div>
                        
                    </tr>
                    <tr>
                        <td>mardi</td>
                        <div className='jour'>
                            <span>Matin</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            </td>
                            <span>Après midi</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            
                            </td>
                        </div>
                        
                    </tr>
                    <tr>
                        <td>mercredi</td>
                        <div className='jour'>
                            <span>Matin</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            </td>
                            <span>Après midi</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            
                            </td>
                        </div>
                        
                    </tr>
                    <tr>
                        <td>jeudi</td>
                        <div className='jour'>
                            <span>Matin</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            </td>
                            <span>Après midi</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            
                            </td>
                        </div>
                        
                    </tr>
                    <tr>
                        <td>vendredi</td>
                        <div className='jour'>
                            <span>Matin</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            </td>
                            <span>Après midi</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            
                            </td>
                        </div>
                        
                    </tr>
                    <tr>
                        <td>samedi</td>
                        <div className='jour'>
                            <span>Matin</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            </td>
                            <span>Après midi</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            
                            </td>
                        </div>
                        
                    </tr>
                    <tr>
                        <td>dimanche</td>
                        <div className='jour'>
                            <span>Matin</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            </td>
                            <span>Après midi</span>
                            <td>
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                                <input type="time" min="07:00" max="00:00" required onChange={()=> {genererHorarireFromInputs()}} />
                            
                            </td>
                        </div>
                        
                    </tr>
                </table>
        </div>
    )
}

export default HorrairesDouverture