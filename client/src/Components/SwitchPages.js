import React from 'react'

const SwitchPages = ({change_current_page,currentPageSwitch}) => {

    const show_change_page = () =>{
        document.querySelector('.change_page').classList.toggle('show_me');
    } 



    return (
        <React.Fragment>
            <div className="filter-contain">
                    <span className="current_order c_item" onClick = {show_change_page}>Page Actuelle :  <strong> {currentPageSwitch} </strong> </span>
                 <div className="change_page">
                       <div className="o_item"  onClick = {() => {change_current_page('boutiques')}}>
                                    
                                   <div className={ (currentPageSwitch == 'boutiques' ) ? 'checkbox c_check' : 'checkbox' } id="boutique">
                                         <div className="white_space"></div>
                                   </div>
                                   <label htmlFor="boutique">Boutiques</label>
                       </div>
                       <div className="o_item" onClick = {() => {change_current_page('produits')}}>
                                    <div className={(currentPageSwitch == 'produits' ) ? 'checkbox c_check' : 'checkbox' } id="produits">
                                        <div className="white_space"></div>
                                    </div>
                                    <label htmlFor="produits" >Prodiuts</label>
                        </div>
                        <div className="o_item" onClick = {() => {change_current_page('categories')}}>
                                    <div className={(currentPageSwitch == 'categories' ) ? 'checkbox c_check' : 'checkbox' } id="categories">
                                        <div className="white_space"></div>
                                    </div>
                                    <label htmlFor="categories" >Categories</label>
                        </div>
                      
                </div>  
            </div>
                 
        </React.Fragment>
    )
}

export default SwitchPages;