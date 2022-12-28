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
import UpdateBoutique from "./UpdateBoutique";
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
  const [createdBeforeInput,setCreatedBeforeInput] = useState("");
  const [createdAfterInput,setCreatedAfterInput] = useState("");
  const [boutiques,setBoutiques] = useState([]);
  const config = {
    headers: { 
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json',
      'Content-Type': 'application/json'}
    };


  

  const getAllBoutiques = () => {
    
      const datas = {
        "limit" : per_page,
        "offset" : offset,
        "orderBy" : orderBy
      };

      if(enConge != "") {
          datas.enConge = 1
      }

      if(createdBefore != "") {
        datas.createdBefore = createdBefore
      }

      if(createdAfter != "") {
        datas.createdAfter = createdAfter
      }

      if(query != "") {
        datas.query = query
      }

      axios.get(`${api}/boutiques`,{ params : datas,headers: {"Authorization" : `Bearer ${token}`} }).then(
        response => {
            if( response.status === 200) {
              setAllpages(Math.ceil((response.data.length) / per_page))
              setBoutiques(response.data);
              setIsloading(false);
            }
        }
    )
  }

  useEffect( () =>{
    setIsloading(true);
    getAllBoutiques();
  },[orderBy,page,enConge,createdBefore,createdAfter]);

  useEffect( () =>{
    change_current_page("boutiques");
  },[]);

  return (is_loading) ? (<Loader/>) : ( 
    <React.Fragment>
        <NavBar
           query = {query}
           change_query = {(new_query)=> { setQuery(new_query)}}
           getAllBoutiques = {()=>{getAllBoutiques()}}
           setIsloading = {(new_is_loading)=>{setIsloading(new_is_loading)}}
        />
        <span id="current_action">{current_action} { (query != "") ? `(recherche : ${query} )` : ""}</span>
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
                changeCreatedBefore = { (new_date_before)=> { setCreatedBefore(new_date_before)}}
                changeCreatedAfter = { (new_date_after)=> { setCreatedAfter(new_date_after)}}
                createdBeforeInput = {createdBeforeInput}
                createdAfterInput = {createdAfterInput}
                changeCreatedBeforeInput = { (new_date_before_input)=> { setCreatedBeforeInput(new_date_before_input)}}
                changeCreatedafterInput = { (new_date_after_input)=> { setCreatedAfterInput(new_date_after_input)}}
        />  
        
         <div className="imgs boutiques">
             { boutiques.map( (boutique) =>  (

                <Boutique
                    boutique = {boutique}
                    getAllBoutiques = {getAllBoutiques}
                  />
                ))
              }
          </div>
          
          <UpdateBoutique
          
          />

    </React.Fragment>
  );
}
export default Boutiques;