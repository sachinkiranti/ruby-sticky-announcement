import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import { store as noticesStore } from '@wordpress/notices';
import {useDispatch} from "@wordpress/data";

const useSettings = () => {
    const [ message, setMessage ] = useState('Hello, World!');
    const [ display, setDisplay ] = useState(true);
    const [ size, setSize ] = useState('medium');

    const { createSuccessNotice } = useDispatch( noticesStore );

    useEffect( () => {
        apiFetch( { path: '/wp/v2/settings' } ).then( ( settings ) => {
            setMessage( settings.ruby_sticky_announcement.message );
            setDisplay( settings.ruby_sticky_announcement.display );
            setSize( settings.ruby_sticky_announcement.size );
        } );
    }, [] );

    const saveSettings = () => {
        apiFetch( {
            path: '/wp/v2/settings',
            method: 'POST',
            data: {
                ruby_sticky_announcement: {
                    message,
                    display,
                    size,
                },
            },
        } ).then( () => {
            createSuccessNotice(
                __( 'Settings saved.', 'unadorned-announcement-bar' )
            );
        } );
    };

    return {
        message,
        setMessage,
        display,
        setDisplay,
        size,
        setSize,
        saveSettings,
    };
};

export default useSettings;