import React, { useState } from 'react';
import { useHistory } from "react-router-dom";
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import Paper from '@mui/material/Paper';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import axios from 'axios';
import logo from "../images/logo.PNG";
import { useNavigate  } from "react-router-dom";


const NavBar = ({query,change_query,user}) => {

  const navigate = useNavigate();


  const deconnexion = () => {
    localStorage.removeItem('token');
    navigate("/");    
  };

  const switchPopUp = () => {
    document.querySelector(".pop-up-fav").classList.toggle("show_me");

  }

  return (
    <div className="navbar">
        <img src={logo} alt="shop"  className="logo" onClick = {()=> {navigate("/boutiques")}}/>
        <form onSubmit={(e)=> {e.preventDefault()}} >
                <div className="search_input">
                    <i class="fas fa-search"></i>
                    <input type="text" onInput={(e)=> {change_query(e.target.value)}}  value={query} id="search_input" />
                </div>           
        </form>
        <div class="avatar-user" onClick={switchPopUp}>
           <span>HL</span>
        </div>
        <div className="pop-up-fav ">
            
            <span> 
                  { (user.length != 0) ? `${user.email} (${user.roles[0]})` :  "Annonyme" }
            </span>  
            <span onClick={()=> {navigate('/me')}} > 
                 Mon Profile
            </span>   
            <span onClick={deconnexion} > 
                 Se Déconecter
            </span>   
                    
        </div>
    </div>
  );
}
export default NavBar;