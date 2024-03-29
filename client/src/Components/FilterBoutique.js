import React, { useState } from 'react'
import AllPages from './AllPages';
import SwitchPages from './SwitchPages';

const FilterBoutique = (
    {
        orderBy,
        current_page,
        all_pages,
        change_page,
        enConge,
        change_order,
        change_enConge,
        change_current_page,
        currentPageSwitch,
        changeCreatedBefore,
        changeCreatedAfter,
        createdBeforeInput,
        createdAfterInput,
        changeCreatedBeforeInput,
        changeCreatedafterInput,
        changeOperation,
        changeBoutiqueUpdate,
        userRole,
        api,
        token
    }) => {

    const ROLE_ADMIN = process.env.ROLE_ADMIN;

    const show_en_conge = () =>{
        document.querySelector('.en_conge').classList.toggle('show_me');

    } 

    const show_orders = () =>{
        document.querySelector('.orders').classList.toggle('show_me');  
    } 
    
    const show_orders_by = () =>{
        document.querySelector('.orders_by').classList.toggle('show_me');  
    } 

    const AppliqueFilterDate = () => {
        change_page(1)
        let dateBeforeOriginal = (document.querySelector("#date_boutique_avant").value).split("-");
        let dateAfterOriginal = (document.querySelector("#date_boutique_apres").value).split("-");
        console.log(typeof dateBeforeOriginal[2] === typeof undefined);
        if(typeof dateBeforeOriginal[2] === typeof undefined) {
            changeCreatedBefore("");
        } else {
            let dateBefore = dateBeforeOriginal[2]+ "/" +dateBeforeOriginal[1]+ "/" +dateBeforeOriginal[0];
            changeCreatedBefore(dateBefore);
        }
        if(typeof dateAfterOriginal[2] === typeof undefined) {
            changeCreatedAfter("");
        } else {
            let dateAfter = dateAfterOriginal[2]+ "/" +dateAfterOriginal[1]+ "/" +dateAfterOriginal[0];
            changeCreatedAfter(dateAfter);
        }

      
    };

   const updateBoutique = (operation)=> {
        changeOperation("add");
        changeBoutiqueUpdate([]);
        document.querySelector(".pop-up-update-add").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');
   }

    return (
        <div className="choices">
                 <SwitchPages 
                    change_current_page={change_current_page}
                    currentPageSwitch={currentPageSwitch}
                    api ={api}
                    token={token}
                 />
                 <div className="filter-container">
                    <span className="current_order c_item c_item_en_conge" onClick = {() => {show_en_conge() }}>En Congé :  <strong> {enConge == 1 ? "oui" : "non"} </strong> </span>
                    <div className="en_conge">
                        <div className="o_item"  onClick = {() => {change_enConge(1);change_page(1)}}>
                                        
                                    <div className={ (enConge == 1 ) ? 'checkbox c_check' : 'checkbox' } id="conge_oui">
                                            <div className="white_space"></div>
                                    </div>
                                    <label htmlFor="conge_oui">Oui</label>
                        </div>
                        <div className="o_item" onClick = {() => {change_enConge(0);change_page(1)}}>
                                        <div className={(enConge == 0 ) ? 'checkbox c_check' : 'checkbox' } id="conge_non">
                                            <div className="white_space"></div>
                                        </div>
                                        <label htmlFor="conge_non" >Non</label>
                            </div>
                        
                    </div>
                 </div>
                 <div className="filter-container">
                    <span className="current_order c_item" onClick = {() => {show_orders() }} >Filtré Par date : <strong> avant/Aprés/entre </strong> </span>
                    <div className="orders orders-first">
                        <div className="o_item first_o" >
                                <div>
                                    <label htmlFor="by_date">Avant</label>
                                    <input type="date" value={createdBeforeInput} onChange={(e)=> {changeCreatedBeforeInput(e.target.value)}} name="date_boutique_avant" id="date_boutique_avant" />
                                </div>
                        </div>
                        <div className="o_item">
                                        
                                <div>
                                    <label htmlFor="by_date">Après</label>
                                    <input type="date"  value={createdAfterInput} onChange={(e)=> {changeCreatedafterInput(e.target.value)}} name="date_boutique_apres" id="date_boutique_apres" />
                                </div>
                            </div>
                            <button onClick={()=> {AppliqueFilterDate()}}>Appliquer</button>
                        
                        
                    </div>
                </div>
                <div className="filter-container">
                    <span className="current_order c_item" onClick = {() => {show_orders_by() }} >
                        Triée Par :  <strong>
                            {(orderBy === 'date_de_creation') ? 'Date de création' : ((orderBy === 'nom') ? "Nom" : "Nombre de produit") } 
                            </strong>
                    </span>
                    <div className="orders orders_by">
                        <div className="o_item first_o"  onClick = {() => {change_order('date_de_creation');change_page(1)}}>
                                        
                                    <div className={ (orderBy == 'date_de_creation' ) ? 'checkbox c_check' : 'checkbox' } id="by_date">
                                            <div className="white_space"></div>
                                    </div>
                                    <label htmlFor="by_date">Date de création</label>
                        </div>
                        <div className="o_item" onClick = {() => {change_order('nombre_de_produits');change_page(1)}}>
                                        
                                        <div className={(orderBy == 'nombre_de_produits' ) ? 'checkbox c_check' : 'checkbox' } id="by_nb_produit">
                                            <div className="white_space"></div>
                                        </div>
                                        <label htmlFor="by_nb_produit" >Nombre de produit</label>
                            </div>
                            <div className="o_item" onClick = {() => {change_order('nom');change_page(1)}}>
                                        
                                        <div className={(orderBy == 'nom' ) ? 'checkbox c_check' : 'checkbox' } id="by_nom">
                                            <div className="white_space"></div>
                                        </div>
                                        <label htmlFor="by_nom" >Nom</label>
                            </div>
                        
                    </div>
                </div>
                <AllPages 
                         current_page = {current_page} 
                         all_pages = {all_pages} 
                         get_page = { (new_page)=> { change_page(new_page)}}
                         
                />
                {
                  
                    userRole == "ROLE_ADMIN" 
                    ? <span className="current_order c_item add_boutique" onClick = {() => {updateBoutique("add")}}> <strong>Ajouter</strong> </span>
                    : ''
                 }

                


        </div>
    )
}

export default FilterBoutique