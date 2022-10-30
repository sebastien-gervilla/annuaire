import { BrowserRouter, Routes, Route } from 'react-router-dom';
import AppStudent from './pages/AppStudent';
import AppStudents from './pages/AppStudents';
import AppUsers from './pages/AppUsers';
import Login from './pages/Login';
import NotFound from './pages/NotFound';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path='/' element={<AppStudents />} />
        <Route path='/login' element={<Login />} />
        <Route path='/student/:id' element={<AppStudent />} />
        <Route path='/users' element={<AppUsers />} />
        <Route path='*' element={<NotFound />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
