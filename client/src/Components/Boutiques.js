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
import FilterBoutique from "./FilterBoutique";
import Boutique from "./Boutique";
import Loader from "./loader";
import logo from "../images/shop.png";
import '../styles/App.css';
import '../styles/AppAfterLogIn.css';


const Boutiques = ({change_current_page,currentPageSwitch}) => {

  const [api,setApi] = useState("http://localhost:8000/api");
  const [token,setToken] = useState(localStorage.getItem("token"));
  const [query,setQuery] = useState('');
  const [result,setResult] = useState('');
  const [is_loading,setIsloading] = useState(true);
  const [cpt_results,setCptResult] = useState(0);
  const [orderBy,setOrderBy] = useState('date_de_creation');
  const [show_choices,setShowchoices] = useState(true);
  const [page,setPage] = useState(1);
  const [offset,setOffest] = useState(0);
  const [per_page,setPerpage] = useState(10);
  const [all_pages,setAllpages] = useState(1);
  const [current_action,setCurrentAction] = useState("Toutes les boutiques");
  const [enConge,setenConge] = useState(null);
  const [createdBefore,setCreatedBefore] = useState("");
  const [createdAfter,setCreatedAfter] = useState("");
  const [boutiques,setBoutiques] = useState([]);


  const getAllBoutiques = () => {
    const config = {
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'}
      };
     
      const datas = {
        "enConge" : 1,
        "createdBefore" : createdBefore,
        "createdAfter" : createdAfter,
        "orderBy" : orderBy,
        "query" : "utchi",
        "offset" : offset,
        "limit" : 3
      };

      axios.post(`${api}/boutiques`,datas,{ headers: {"Authorization" : `Bearer ${token}`} }).then(
        response => {
            if( response.status === 200) {
              console.log(response.data);
              setBoutiques(response.data);
              setIsloading(false);
            }
        }
    )
  }

  useEffect( () =>{
    setIsloading(true);
    getAllBoutiques();
  },[query,orderBy,page,enConge]);

  useEffect( () =>{
    change_current_page("boutiques");
  },[]);

  return (is_loading) ? (<Loader/>) : ( 
    <React.Fragment>
        <NavBar />
        <span id="current_action">{current_action}</span>
        <FilterBoutique 
                orderBy = {orderBy}
                current_page = {page} 
                all_pages = {all_pages }
                change_page = { (new_page)=> { setPage(new_page)}}
                enConge = {enConge}
                change_order = { (new_order)=> { setOrderBy(new_order)}}
                change_enConge = { (new_conge)=> { setenConge(new_conge)}}
                change_current_page = {change_current_page}
                currentPageSwitch= {currentPageSwitch}
        />  
        
         <div className="imgs">
             { boutiques.map( (boutique) =>  (

                <Boutique
                    boutique = {boutique}
                    getAllBoutiques = {getAllBoutiques}
                  />
                ))
              }
          </div>
        


    </React.Fragment>
  );
}
export default Boutiques;