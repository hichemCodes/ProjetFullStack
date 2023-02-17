import React, { useState,useEffect } from 'react';
import axios from 'axios';

const SwitchPages = ({change_current_page,currentPageSwitch,api,token}) => {

    const [user,setUser] = useState([]);
    const [userRole,setUserRole] = useState([]);

    const show_change_page = () =>{
        document.querySelector('.change_page').classList.toggle('show_me');
    } 



    const getCurrentUser = ()=> {
        const datas = {};
        axios.get(`${api}/users/me`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
          response => {
              if( response.status === 200) {
                setUser(response.data[0]);
                setUser(response.data[0]);
                setUserRole(response.data[0].roles[0])
              }
          }
        )
      }
      useEffect( () =>{
        getCurrentUser();
      },[]);



    return (
        <React.Fragment>
            <div className="filter-container">
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
                                    <label htmlFor="produits" >Produits</label>
                        </div>
                        <div className="o_item" onClick = {() => {change_current_page('categories')}}>
                                    <div className={(currentPageSwitch == 'categories' ) ? 'checkbox c_check' : 'checkbox' } id="categories">
                                        <div className="white_space"></div>
                                    </div>
                                    <label htmlFor="categories" >Categories</label>
                        </div>
                        {(userRole === "ROLE_ADMIN") 
                        ? 
                         <React.Fragment>
                                <div className="o_item" onClick = {() => {change_current_page('administrateur')}}>
                                    <div className={(currentPageSwitch == 'administrateur' ) ? 'checkbox c_check' : 'checkbox' } id="administrateur">
                                        <div className="white_space"></div>
                                    </div>
                                    <label htmlFor="administrateur" >Administrateur</label>
                                </div>
                      
                         </React.Fragment>
                        : ''
                    
                        }
                        
                </div>  
            </div>
                 
        </React.Fragment>
    )
}

export default SwitchPages;