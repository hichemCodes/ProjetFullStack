import React, { useState } from 'react';
import { useNavigate  } from "react-router-dom";
import Avatar from '@mui/material/Avatar';
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import Link from '@mui/material/Link';
import Paper from '@mui/material/Paper';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import axios from 'axios';
import logo from "../images/shop.png";
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';

const theme = createTheme();

const Register = (props) => {
  
  const [email,setEmail] = useState("");
  const [nom,setNom] = useState("");
  const [prenom,setPrenom] = useState("");
  const [password,setPassword] = useState("");
  const [passwordConfirm,setPasswordConfirm] = useState("");
  const [vile, setVile] = useState('Sélectionner une vile');
  const navigate = useNavigate();


  const handleChange = (event) => {
    setVile(event.target.value);
  };

  //inscription 
  const handleSubmit = (event) => {
    event.preventDefault();
    const isValid = true;
    //validation


    if(isValid) {
        const datas = {
          "email": email,
          "password": password,
          "nom": nom,
          "prenom": prenom
        }
        console.log(datas);

        axios.post(`${props.api}/register`, datas,).then(
          response => {
            console.log(response.status);
              if( response.status === 200) {
                navigate("/login");       
              }
          }
      )
    }
  
  }


  return (
    <ThemeProvider theme={theme}>
      <Grid container component="main" sx={{ height: '100vh'  }}>
        <CssBaseline />
        <Grid
          item
          xs={false}
          sm={3}
          md={7}
          className='register-left-section'
        />
        <Grid item xs={12} sm={8} md={5} component={Paper} elevation={6} square className='register-right-section'>
          <Box
            sx={{
              my: 8,
              mx: 4,
              display: 'flex',
              flexDirection: 'column',
              alignItems: 'center',
            }}
            className='regiter-box'
          >
            <img src={logo} alt="shop"  className="appLogo appLogoRegiter"/>
            <Typography component="h1" variant="h5">
            </Typography>
            <Box component="form" noValidate onSubmit={handleSubmit} sx={{ mt: 1 }}>
              <div className="flex-inputs">
                <TextField
                    margin="normal"
                    required
                    id="nom"
                    label="Nom"
                    name="nom"
                    onChange={(e)=> {setNom(e.target.value)}}
                    focused 
                />
                <TextField
                    margin="normal"
                    required
                    name="prenom"
                    label="Prenom"
                    id="prenom"
                    onChange={(e)=> {setPrenom(e.target.value)}}
                    focused
                />
              </div>
              <TextField
                margin="normal"
                required
                fullWidth
                name="email"
                label="Email"
                type="email"
                id="email"
                onChange={(e)=> {setEmail(e.target.value)}}
                focused
              />
              <TextField
                margin="normal"
                required
                fullWidth
                name="password"
                label="Mo de passe"
                type="password"
                id="password"
                onChange={(e)=> {setPassword(e.target.value)}}
                autoComplete="current-password"
                focused
              />
               <TextField
                margin="normal"
                required
                fullWidth
                name="passwordConfirm"
                label="Confirmation du mot de passe"
                type="password"
                id="passwordConfirm"
                onChange={(e)=> {setPasswordConfirm(e.target.value)}}
                autoComplete="current-password"
                focused
              />
               <TextField
                    margin="normal"
                    name="adresse"
                    label="Adresse"
                    id="codePostal"
                    fullWidth
                    focused
                />
              <div className='flex-inputs'>
                <TextField
                    margin="normal"
                    name="codePostal"
                    label="Code Postal"
                    id="codePostal"
                    focused
                />
                  <Select
                    labelId="demo-simple-select-label"
                    id="demo-simple-select"
                    label="Vile"
                    value = {vile}
                    onChange={handleChange}
                    focused
                    
                  >
                    <MenuItem value={10}>Ten</MenuItem>
                    <MenuItem value={20}>Twenty</MenuItem>
                    <MenuItem value={30}>Thirty</MenuItem>
                  </Select>
              </div>
    
              <Button
                type="submit"
                fullWidth
                variant="contained"
                sx={{ mt: 3, mb: 2 }}
              >
                 je m'inscit
              </Button>
            </Box>
          </Box>
        </Grid>
      </Grid>
    </ThemeProvider>
  );
}
export default Register;