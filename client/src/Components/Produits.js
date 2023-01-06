import React, { useState,useEffect } from 'react';
import { useHistory } from "react-router-dom";
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import Paper from '@mui/material/Paper';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import axios from 'axios';
import NavBar from "./NavBar";
import Loader from "./loader";
import '../styles/App.css';
import '../styles/AppAfterLogIn.css';
import '../styles/produits.css';

import Produit from './Produit';
import FilterProduit from './FilterProduits';
import UpdateProduit from './UpdateProduit';


const Produits = ({change_current_page,currentPageSwitch}) => {

  const [api,setApi] = useState("http://localhost:8000/api");
  const [token,setToken] = useState(localStorage.getItem("token"));
  const [query,setQuery] = useState('');
  const [is_loading,setIsloading] = useState(true);
  const [orderBy,setOrderBy] = useState('date_de_creation');
  const [page,setPage] = useState(1);
  const [offset,setOffest] = useState(0);
  const [per_page,setPerpage] = useState(10);
  const [all_pages,setAllpages] = useState(1);
  const [current_action,setCurrentAction] = useState("Tous les produits");
  const [operation,setOperation] = useState("add");
  const [produits,setProduits] = useState([]);
  const [produitUpdate,setProduitUpdate] = useState([]);

  
  const config = {
    headers: { 
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
      'Content-Type': 'application/json'}  
  };

  const getAllProduits = () => {

      setOffest(per_page * (page - 1));

      const datas = {
        "limit" : per_page,
        "offset" : per_page * (page - 1),//a construire
        "orderBy" : orderBy
      };

      
      if(query != "") {
        datas.query = query
      }

      axios.get(`${api}/produits`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
        response => {
            if( response.status === 200) {
              setProduits(response.data);
              setIsloading(false);
              console.log(produits)
            }
        }
      )
  }
  /*
  const synchronizeBoutiqueCount = () => {
    axios.get(`${api}/boutiquesCount`,config).then(
      response => {
          if( response.status === 200) {
            setAllpages(Math.ceil((response.data[0].nombreDeBoutiques) / per_page))
          }
      }
    )
  }*/
  
  useEffect( () =>{
    setIsloading(true);
    getAllProduits();
  },[page,query]);

  useEffect( () =>{
    change_current_page("produits");
    //synchronizeBoutiueCount();
  },[]);


  return ( 
    <React.Fragment>
        <NavBar
           query = {query}
           change_query = {(new_query)=> { setQuery(new_query)}}
        />
        <span id="current_action">{current_action} { (query != "") ? `(recherche : ${query} )` : ""}</span>
        <FilterProduit 
                
                current_page = {page} 
                all_pages = {all_pages }
                change_page = { (new_page)=> { setPage(new_page)}}
                change_current_page = {change_current_page}
                currentPageSwitch= {currentPageSwitch}
                changeOperation = {(new_operation)=> {setOperation(new_operation)}}
                changeProduitUpdate = {(new_update_produit)=> {setProduitUpdate(new_update_produit)}}
        />
        {
          (is_loading) ? (<Loader/>) 
          : 
            <div className="imgs boutiques produits">
                { produits.map( (produit) =>  (
                    <Produit
                        produit = {produit}
                        getAllProduits = {getAllProduits}
                        produits = {produits}
                        changeOperation = {(new_operation)=> {setOperation(new_operation)}}
                        changeProduitUpdate = {(new_update_produit)=> {setProduitUpdate(new_update_produit)}}                        
                   />
                   
                  ))
                }
            </div>
        }
         <UpdateProduit
            operation={operation}
            produitUpdate={produitUpdate}
            config = {config}
            api = {api}
            getAllProduits = {getAllProduits}
            changeOperation = {(new_operation)=> {setOperation(new_operation)}}
          />
          <div className="cover_add fade"></div>
        
         
    </React.Fragment>
  );
}
export default Produits;