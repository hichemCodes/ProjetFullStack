import React from 'react'
import AllPages from './AllPages';

const FilterBoutique = ({orderBy,current_page,all_pages,change_page,enConge,change_order,change_enConge}) => {

    const show_en_conge = () =>{
        document.querySelector('.en_conge').classList.toggle('show_me');

    } 

    const show_orders = () =>{
        document.querySelector('.orders').classList.toggle('show_me');  
    } 

    return (
        <div className="choices">
                 <span className="current_order c_item" onClick = {() => {show_en_conge() }}>En Congé :  <strong> {enConge} </strong> </span>
                 <div className="en_conge">
                       <div className="o_item"  onClick = {() => {change_enConge('oui')}}>
                                    
                                   <div className={ (enConge == 'oui' ) ? 'checkbox c_check' : 'checkbox' } id="conge_oui">
                                         <div className="white_space"></div>
                                   </div>
                                   <label htmlFor="conge_oui">Oui</label>
                       </div>
                       <div className="o_item" onClick = {() => {change_enConge('non')}}>
                                    <div className={(enConge == 'non' ) ? 'checkbox c_check' : 'checkbox' } id="conge_non">
                                        <div className="white_space"></div>
                                    </div>
                                    <label htmlFor="conge_non" >Non</label>
                        </div>
                      
                </div>
                <span className="current_order c_item" onClick = {() => {show_orders() }} >Filtré Par date : <strong> avant xx/xx/xxx </strong> </span>
                <div className="orders">
                       <div className="o_item first_o"  onClick = {() => {change_order('Date de création')}}>
                                    
                                   <div className={ (orderBy == 'Date de création' ) ? 'checkbox c_check' : 'checkbox' } id="by_date">
                                         <div className="white_space"></div>
                                   </div>
                                   <label htmlFor="by_date">Avant</label>
                       </div>
                       <div className="o_item" onClick = {() => {change_order('Nombre de produits')}}>
                                    
                                    <div className={(orderBy == 'Nombre de produits' ) ? 'checkbox c_check' : 'checkbox' } id="by_nb_produit">
                                        <div className="white_space"></div>
                                    </div>
                                    <label htmlFor="by_nb_produit" >Aprés</label>
                        </div>
                        <div className="o_item" onClick = {() => {change_order('Nombre de produits')}}>
                                    
                                   <input type="date" name="date_boutique" id="date_boutique" />
                        </div>
                      
                </div>
                <span className="current_order c_item" onClick = {() => {show_orders() }} >Triée Par :  <strong> {orderBy} </strong> </span>
                <div className="orders">
                       <div className="o_item first_o"  onClick = {() => {change_order('Date de création')}}>
                                    
                                   <div className={ (orderBy == 'Date de création' ) ? 'checkbox c_check' : 'checkbox' } id="by_date">
                                         <div className="white_space"></div>
                                   </div>
                                   <label htmlFor="by_date">date de création</label>
                       </div>
                       <div className="o_item" onClick = {() => {change_order('Nombre de produits')}}>
                                    
                                    <div className={(orderBy == 'Nombre de produits' ) ? 'checkbox c_check' : 'checkbox' } id="by_nb_produit">
                                        <div className="white_space"></div>
                                    </div>
                                    <label htmlFor="by_nb_produit" >Nombre de produit</label>
                        </div>
                      
                </div>
                <AllPages 
                         current_page = {current_page} 
                         all_pages = {all_pages} 
                         get_page = { ()=> { console.log("page changed")}}
                         
                />

                


        </div>
    )
}

export default FilterBoutique