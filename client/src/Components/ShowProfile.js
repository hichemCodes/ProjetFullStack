import React, { useState,useEffect, useRef } from 'react';
import NavBar from './NavBar';
import Button from '@mui/material/Button';
import { useNavigate  } from "react-router-dom";
import '../styles/ShowProfile.css';

const ShowProfile = ({user}) => {

    const navigate = useNavigate();
    const deconnexion = () => {
        localStorage.removeItem('token');
        navigate(`/`); 
    } 

    return (
        <React.Fragment>
            <NavBar user={user}/>
            <div class="container show_profile">
                
                <div className="show_profile_card card">
                    <div className="card-header"></div>
                    <div className="card-body">
                        <div className="inner">
                            <div className='logo_show'>
                                 <span>HL</span>
                            </div>
                            <div >{ (user.length != 0) ? `${user.nom} ${user.prenom}` : ''}</div>
                            <div className="color__gray">{ (user.length != 0) ? `${user.roles[0]}` : ''}</div>
                        </div>
                    </div>
                    <div className="card-footer">
                        <Button
                                type="submit"
                                id="boutique_btn_update"
                                fullWidth
                                variant="contained"
                                sx={{ mt: 3, mb: 2 }}
                                onClick = {()=> { deconnexion()}}
                            >
                                Deconnexion
                        </Button>  
                    </div>
                </div>
            </div>
        </React.Fragment>
        
    )
}

export default ShowProfile;