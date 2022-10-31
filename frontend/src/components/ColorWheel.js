import { useState } from 'react';
import Wheel from '@uiw/react-color-wheel';

const ColorWheel = ({ onChange, defaultColor = '#fff' }) => {

    const [colorInput, setColorInput] = useState(defaultColor);
    const [colorWheel, setColorWheel] = useState({
        color: defaultColor,
        isOpen: false
    });

    const handleWheelChanges = newColor => {
        setColorInput(newColor);
        setColorWheel({...colorWheel, color: newColor});
        onChange(newColor);
    }

    const handleChangeColor = color => {
        if (!color) return;
        if (color[0] !== '#') return;
        const newColor = color.substr(1, 7);
        if (newColor.split('').find(digit => !allowedChars.includes(digit))) return;

        const length = newColor.length;
        if (length > 6) return;
        isLengthCorrect(length) ? handleWheelChanges(color) : setColorInput(color);
    }

    const isLengthCorrect = (length) => {
        if (length < 3) return false;
        if (length === 6 || length === 3) return true;
        return false;
    }

    return (
        <div className="color-wheel_wrapper">
            <p>Sélectionnez une couleur</p>
            <Wheel
                color={colorWheel.color}
                onChange={color => handleWheelChanges(color.hex)}
            />
            <input type="text" value={colorInput} 
            onChange={event => handleChangeColor(event.target.value)} />
        </div>
    );
};

export default ColorWheel;

const allowedChars = [
    '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
    'a', 'b', 'c', 'd', 'e', 'f',
]