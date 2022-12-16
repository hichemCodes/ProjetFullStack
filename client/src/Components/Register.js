import * as React from 'react';
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


const theme = createTheme();

const Register = () => {
  const handleSubmit = (event) => {
    event.preventDefault();
    
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
            <Typography component="h1" variant="h5">
              Inscription
            </Typography>
            <Box component="form" noValidate onSubmit={handleSubmit} sx={{ mt: 1 }}>
              <div className="flex-inputs">
                <TextField
                    margin="normal"
                    required
                    id="nom"
                    label="Nom"
                    name="nom"
                    focused 
                />
                <TextField
                    margin="normal"
                    required
                    name="prenom"
                    label="Prenom"
                    id="prenom"
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
                autoComplete="current-password"
                focused
              />
              <div className='flex-inputs'>
                <TextField
                    margin="normal"
                    required
                    name="codePostal"
                    label="Code Postal"
                    id="codePostal"
                    focused
                />
                <TextField
                    margin="normal"
                    name="vile"
                    label="Vile"
                    id="vile"
                    focused
                />
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