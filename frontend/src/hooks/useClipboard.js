import React, { useEffect, useRef, useState } from 'react';

export default function useClipboard() {
    const [anchor, setAnchor] = useState(null);
    const messageRef = useRef(null);

    useEffect(() => {
        anchor ? setCopyMessage(anchor) : removeCopyMessage();

        anchor && anchor.addEventListener('click', handleCopy);
    }, [anchor]);

    const setCopyMessage = (anchor) => {
        const msg = document.createElement('p');
        msg.classList.add('copy-msg');
        msg.textContent = 'Copier';
        const rect = anchor.getBoundingClientRect();
        msg.style.left = (rect.x + rect.width * 2 / 3) + 'px';
        msg.style.top = (rect.y + rect.height * 1.5) + 'px';
        document.body.appendChild(msg);
        messageRef.current = msg;
        setTimeout(() => msg.classList.add('appear'), 1);
    }
    
    const removeCopyMessage = (anchor) => {
        if (!messageRef.current) return;
        messageRef.current.classList.remove('appear');
        setTimeout(() => {
            document.body.removeChild(messageRef.current);
            messageRef.current = null;
        }, 1);
    }

    const handleCopy = event => {
        if (!event.target.textContent) return;
        navigator.clipboard.writeText(event.target.textContent);
        messageRef.current.textContent = "Collé !";
    }

    return { setAnchor };
}