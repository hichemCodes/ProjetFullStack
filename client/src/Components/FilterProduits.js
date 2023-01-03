import React, { useState } from 'react'
import AllPages from './AllPages';
import SwitchPages from './SwitchPages';

const FilterProduit = (
    {
        current_page,
        all_pages,
        change_page,
        change_current_page,
        currentPageSwitch,
        changeOperation,
        changeProduitUpdate
    }) => {

    
    const show_boutique = () =>{
        document.querySelector('.filter_produit_boutique').classList.toggle('show_me');
    } 

    const show_categories = () =>{
        document.querySelector('.filter_produit_categories').classList.toggle('show_me');  
    } 

    const updateBoutique = (operation)=> {
        /* changeOperation("add");
        changeBoutiqueUpdate([]);
        document.querySelector(".pop-up-update-add").classList.toggle('show_me');
        document.querySelector(".cover_add").classList.toggle('fade');*/
    }

    return (
        <div className="choices">
                <SwitchPages 
                    change_current_page={change_current_page}
                    currentPageSwitch={currentPageSwitch}
                 />
                  <div className="filter-container">
                    <span className="current_order c_item c_item_en_conge" onClick = {() => {show_boutique() }}>Filtré Par Boutique</span>
                    <div className="en_conge filter_produit_boutique">
    
                    </div>
                </div>
                <div className="filter-container">
                    <span className="current_order c_item filter_produit_categories"  onClick = {() => {show_categories() }} >Filtré Par categorie </span>
                    <div className="orders orders-first">

                    </div>
                </div>
                <AllPages 
                    current_page = {current_page} 
                    all_pages = {all_pages} 
                    get_page = { (new_page)=> { change_page(new_page)}}
                />
                <span className="current_order c_item add_boutique" onClick = {() => {updateBoutique("add")}}> <strong>Ajouter</strong> </span>

                


        </div>
    )
}

export default FilterProduit