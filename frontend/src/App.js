import { BrowserRouter, Routes, Route } from 'react-router-dom';
import AppStudent from './pages/AppStudent';
import AppStudents from './pages/AppStudents';
import Login from './pages/Login';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path='/' element={<AppStudents />} />
        <Route path='/login' element={<Login />} />
        <Route path='/student/:id' element={<AppStudent />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
