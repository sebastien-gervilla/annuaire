import React, { useEffect, useRef, useState } from 'react';

export default function useClipboard(timeout = 150) {
    const [anchor, setAnchor] = useState(null);
    const messageRef = useRef(null);

    useEffect(() => {
        resetCopyMessage(anchor);
    }, [anchor]);

    const resetCopyMessage = (anchor) => {
        removeCopyMessage();
        setCopyMessage(anchor);
        anchor && anchor.addEventListener('click', handleCopy);
    }

    const setCopyMessage = (anchor) => {
        if (!anchor) return;
        const msg = document.createElement('p');
        msg.classList.add('copy-msg');
        msg.textContent = 'Copier';
        const rect = anchor.getBoundingClientRect();
        msg.style.left = (rect.x + rect.width * 2 / 3) + 'px';
        msg.style.top = (rect.y + rect.height * 1.5) + 'px';
        document.body.appendChild(msg);
        messageRef.current = msg;
        setTimeout(() => msg.classList.add('appear'), timeout);
    }
    
    const removeCopyMessage = () => {
        if (!messageRef.current) return;
        const msg = messageRef.current;
        msg.classList.remove('appear');
        messageRef.current = null;
        setTimeout(() => document.body.removeChild(msg), timeout);
    }

    const handleCopy = event => {
        if (!event.target.textContent) return;
        navigator.clipboard.writeText(event.target.textContent);
        messageRef.current.textContent = "Collé !";
    }

    return { setAnchor };
}