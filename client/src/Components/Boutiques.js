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
import Assigner from "./Assigner";
import Boutique from "./Boutique";
import Loader from "./loader";
import logo from "../images/shop.png";
import '../styles/App.css';
import '../styles/AppAfterLogIn.css';


const Boutiques = ({api,config,change_current_page,currentPageSwitch,changeCurrentShowData}) => {

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
  const [enConge,setenConge] = useState("");
  const [createdBefore,setCreatedBefore] = useState("");
  const [createdAfter,setCreatedAfter] = useState("");
  const [createdBeforeInput,setCreatedBeforeInput] = useState("");
  const [createdAfterInput,setCreatedAfterInput] = useState("");
  const [operation,setOperation] = useState("add");
  const [boutiqueUpdate,setBoutiqueUpdate] = useState([]);
  const [boutiques,setBoutiques] = useState([]);
  const [nonAssigners,setNonAssigner] = useState([]);



    const getAllBoutiques = () => {

       setOffest(per_page * (page - 1));

        const datas = {
          "limit" : per_page,
          "offset" : per_page * (page - 1),//a construire
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
                console.log(response.data);
                setBoutiques(response.data);
                setIsloading(false);
                console.log(boutiques)
              }
          }
        )
    }

    const getAllProduitsNonAssigner = () => {
      axios.get(`${api}/produits/nonAssigner`,config).then(
        response => {
            if( response.status === 200) {
               console.log(response.data);
               setNonAssigner(response.data)
            }
        }
      )
  }

    const synchronizeBoutiqueCount = () => {
      axios.get(`${api}/boutiquesCount`,config).then(
        response => {
            if( response.status === 200) {
              setAllpages(Math.ceil((response.data[0].nombreDeBoutiques) / per_page))
            }
        }
      )
    }
  
  useEffect( () =>{
    setIsloading(true);
    getAllBoutiques();
  },[orderBy,page,enConge,createdBefore,createdAfter,query]);

  useEffect( () =>{
    change_current_page("boutiques");
    synchronizeBoutiqueCount();
  },[]);


  return ( 
    <React.Fragment>
        <NavBar
           query = {query}
           change_query = {(new_query)=> { setQuery(new_query)}}
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
                changeOperation = {(new_operation)=> {setOperation(new_operation)}}
                changeBoutiqueUpdate = {(new_update_boutique)=> {setBoutiqueUpdate(new_update_boutique)}}
        />  
        {
          (is_loading) ? (<Loader/>) 
          : 
            <div className="imgs boutiques">
                { boutiques.map( (boutique) =>  (

                  <Boutique
                      boutique = {boutique}
                      getAllBoutiques = {getAllBoutiques}
                      boutiques = {boutiques}
                      changeOperation = {(new_operation)=> {setOperation(new_operation)}}
                      changeBoutiqueUpdate = {(new_update_boutique)=> {setBoutiqueUpdate(new_update_boutique)}}
                      getAllProduitsNonAssigner = {getAllProduitsNonAssigner}
                      changeCurrentShowData = {changeCurrentShowData}
                    />
                  ))
                }
            </div>
        }
        
          <UpdateBoutique
            operation={operation}
            boutiqueUpdate={boutiqueUpdate}
            config = {config}
            api = {api}
            getAllBoutiques = {getAllBoutiques}
            changeOperation = {(new_operation)=> {setOperation(new_operation)}}
          />
          <div className="cover_add fade"></div>

          <Assigner 
             config = {config}
             api = {api}
             nonAssigners = {nonAssigners}
             changeNonAssigner = {(new_non_assigner)=> { setNonAssigner(new_non_assigner)}}
          />
    </React.Fragment>
  );
}
export default Boutiques;