import './index.scss';

import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';
import {SettingsPage} from "./components";

domReady( () => {
    const root = createRoot(
        document.getElementById( 'ruby-sticky-announcement-settings' )
    );

    root.render( <SettingsPage /> );
} );