import React, { useState,useEffect, useRef } from 'react';
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
import Produit from './Produit';
import FilterProduit from './FilterProduits';
import UpdateProduit from './UpdateProduit';
import AssignerCategorieToProduit from './AssignerCategorieToProduit';

import '../styles/App.css';
import '../styles/AppAfterLogIn.css';
import '../styles/produits.css';

const Produits = ({token,api,config,change_current_page,currentPageSwitch,changeCurrentShowDataProduit,changeUser}) => {

 
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
  const [allBoutiqueToProduit,setAllBoutiqueToProduit] = useState([]);
  const [allCategorieToProduit,setAllCategorieToProduit] = useState([]);
  const [filterParBoutique,setFilterParBoutique] = useState(null);
  const [filterParCategorie,setFilterParCategorie] = useState(null);
  const [allCategiriesOfSelectedProduit,setAllCategiriesOfSelectedProduit] = useState([]);
  const [user,setUser] = useState([]);
  const [myProducts,setMyProducts] = useState([]);
  const [userRole,setUserRole] = useState([]);


  const getAllProduits = () => {

      getMyProducts();
      getCurrentUser();
      setOffest(per_page * (page - 1));

      const datas = {
        "limit" : per_page,
        "offset" : per_page * (page - 1),//a construire
      };

      
      if(query != "") {
        datas.query = query;
      }

      if(filterParBoutique != null) {
          datas.boutique = filterParBoutique;
      }

      if(filterParCategorie != null) {
          datas.categorie = filterParCategorie;
      }

      axios.get(`${api}/produits`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
        response => {
            if( response.status === 200) {
              setProduits(response.data[0]);
              setIsloading(false);
              setAllpages(Math.ceil((response.data[1].allPages) / per_page));
            } 
        }
      )
  }

  const getAllBoutiqueToFilterProduit = () => {

    const datas = {
      "limit" : 100,
      "offset" : 0
    };

    axios.get(`${api}/boutiques`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
      response => {
          if( response.status === 200) {
            setAllBoutiqueToProduit(response.data[0]);
          }
      }
    )
  }

  const getAllCategoriesToFilterProduit = () => {

    const datas = {
      "limit" : 100,
      "offset" : 0
    };

    axios.get(`${api}/categories`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
      response => {
          if( response.status === 200) {
            setAllCategorieToProduit(response.data[0]);
          }
      }
    )
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

  const getMyProducts = () => {
    console.log(user);
    axios.get(`${api}/users/${user.id}/produits`,{headers: {"Authorization" : `Bearer ${token}`} }).then(
      response => {
          if( response.status === 200) {
             console.log(response);
             setMyProducts(response.data);
          }
      }
    )
  }

  useEffect( () =>{
    setIsloading(true);
    getCurrentUser();
    getAllProduits();
    getMyProducts();
  },[page,query,filterParBoutique,filterParCategorie,currentPageSwitch]);


  useEffect( () =>{
    change_current_page("produits");
    getCurrentUser();
    getAllBoutiqueToFilterProduit();
    getAllCategoriesToFilterProduit();
    getMyProducts();
  },[]);

  useEffect( () =>{
    console.log(allCategiriesOfSelectedProduit);
},[allCategiriesOfSelectedProduit]);


  return ( 
    <React.Fragment>
        <NavBar
           query = {query}
           change_query = {(new_query)=> { setQuery(new_query)}}
           user = {user}
           changeUser = {changeUser}
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
                changeFilterParBoutique = {(new_filter) => {setFilterParBoutique(new_filter)}}
                changeFilterParCategorie = {(new_filter) => {setFilterParCategorie(new_filter)}}
                allBoutiqueToProduit = {allBoutiqueToProduit}
                allCategorieToProduit = {allCategorieToProduit}
                filterParBoutique = {filterParBoutique}
                filterParCategorie = {filterParCategorie}
                userRole= {userRole}
                api={api}
                token={token}
        />
        {
          (is_loading) ? (<Loader/>) 
          : 
            <div className="imgs boutiques produits">
                { 
                produits.map( (produit) =>  (
                    <Produit
                        api = {api}
                        token = {token}
                        produit = {produit}
                        getAllProduits = {getAllProduits}
                        produits = {produits}
                        changeOperation = {(new_operation)=> {setOperation(new_operation)}}
                        changeProduitUpdate = {(new_update_produit)=> {setProduitUpdate(new_update_produit)}}  
                        changeAllCategiriesOfSelectedProduit = {(new_value) => { setAllCategiriesOfSelectedProduit(new_value)} }     
                        changeCurrentShowDataProduit = {changeCurrentShowDataProduit}      
                        myProducts = {myProducts} 
                        role = {userRole}

                    />
                  
                  ))
                }
            </div>
        }
         <UpdateProduit
            operation={operation}
            produitUpdate={produitUpdate}
            token = {token}
            api = {api}
            getAllProduits = {getAllProduits}
            changeOperation = {(new_operation)=> {setOperation(new_operation)}}
          />
          <div className="cover_add fade"></div>
          <AssignerCategorieToProduit 
              api = {api}
              token = {token}
              allCategorieToProduit = {allCategorieToProduit}
              allCategiriesOfSelectedProduit = {allCategiriesOfSelectedProduit}
              getAllProduits = {getAllProduits}
          />
        
         
    </React.Fragment>
  );
}
export default Produits;