import { BrowserRouter, Routes, Route } from 'react-router-dom';
import AppParameters from './pages/AppParameters';
import AppStudent from './pages/AppStudent';
import AppStudents from './pages/AppStudents';
import AppUsers from './pages/AppUsers';
import Login from './pages/Login';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path='/' element={<AppStudents />} />
        <Route path='/login' element={<Login />} />
        <Route path='/student/:id' element={<AppStudent />} />
        <Route path='/users' element={<AppUsers />} />
        <Route path='/parameters' element={<AppParameters />} />
        <Route path='*' element={<AppStudents />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
