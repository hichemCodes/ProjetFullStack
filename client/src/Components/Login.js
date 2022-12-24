import React, { useState } from 'react';
import { useNavigate  } from "react-router-dom";
import Button from '@mui/material/Button';
import CssBaseline from '@mui/material/CssBaseline';
import TextField from '@mui/material/TextField';
import Paper from '@mui/material/Paper';
import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import { createTheme, ThemeProvider } from '@mui/material/styles';
import axios from 'axios';
import logo from "../images/shop.png";





const Login = (props) => {

  const [email,setEmail] = useState("");
  const [password,setPassword] = useState("");
  const [api,setApi] = useState("http://localhost:8000/api");
  const [token,setToken] = useState("");
  const navigate = useNavigate();
  const theme = createTheme();

  const handleSubmit = (event) => {
    event.preventDefault();

    const datas = {
      "username": email,
      "password": password,
    };

    axios.post(`${api}/login_check`, datas).then(
        response => {
          console.log(response.status);
             if( response.status === 200) {
              setToken(response.data.token);
              localStorage.setItem('token',response.data.token);
              navigate("/boutiques");       
            }
        }
    ).catch( error => {
      if(error.request.status === 401) {
        ///form validation with toast
        console.log("l'email ou le mot de passe sont inccorect");
      }
    })
    
  };

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
          >   
            <img src={logo} alt="shop"  className="appLogo"/>
            <Box component="form" noValidate onSubmit={handleSubmit} sx={{ mt: 1 }}>
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
                  
              <Button
                type="submit"
                fullWidth
                variant="contained"
                sx={{ mt: 3, mb: 2 }}
                id="connexion"
              >
                 Connexion
              </Button>
            </Box>
          </Box>
        </Grid>
      </Grid>
    </ThemeProvider>
  );
}
export default Login;