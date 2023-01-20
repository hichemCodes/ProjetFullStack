import React, { useEffect, useState } from 'react';
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
  const [adresse, setAdresse] = useState("");
  const [role,setRole] = useState("ROLE_LIVREUR_VENDEUR");
  const [ville, setVille] = useState(7);
  const [villes, setVilles] = useState([]);

  const navigate = useNavigate();


  const handleChange = (event) => {
    setVille(event.target.value);
  };

  const handleChangeRole = (event) => {
    setRole(event.target.value);
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
          "prenom": prenom,
          "roles" : role,
          "ville_id": ville,
          "complement_adresse": adresse
        }

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

  useEffect( () =>{
    //get all villes 
    const datas = {};
    axios.get(`${props.api}/villes`,{ params : datas}).then(
      response => {
          if( response.status === 200) {
            setVilles(response.data);
            setVille(response.data[0].id);
            console.log(response.data[0].id);
          }
      }
    )
  },[]);
  



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
                label="Mot de passe"
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
               <FormControl fullWidth>
                  <InputLabel id="demo-simple-select-label">Role</InputLabel>
                    <Select
                        id="demo-simple-select-role"
                        label="Role"
                        type="text"
                        margin="normal"
                        value = {role}
                        defaultValue= {role}
                        fullWidth
                        required
                        onChange={handleChangeRole}
                        focused
                      >
                        <MenuItem value={'ROLE_ADMIN'}>ADMIN</MenuItem>
                        <MenuItem value={'ROLE_LIVREUR_VENDEUR'}>LIVREUR / VENDEUR</MenuItem>
                    </Select>
                  </FormControl>
               <TextField
                    margin="normal"
                    name="adresse"
                    label="Adresse"
                    onChange={(e)=> {setAdresse(e.target.value)}}
                    fullWidth
                    focused
                />
              <div className='flex-inputs'>
               
                 <FormControl fullWidth>
                  <InputLabel id="demo-simple-select-label">Ville</InputLabel>
                    <Select
                        labelId="demo-simple-select-label"
                        id="demo-simple-select"
                        label="Ville"
                        value = {ville}
                        defaultValue= {ville}
                        onChange={handleChange}
                        margin="normal"
                        
                      >
                      {villes.map ( v => (
                          <MenuItem value={v.id}>{`${v.nom} (${v.code_postale})`}</MenuItem>
                      ))}
                  </Select>
                  </FormControl>
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