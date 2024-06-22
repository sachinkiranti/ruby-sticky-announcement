import { __ } from '@wordpress/i18n';

import {TextareaControl, ToggleControl, FontSizePicker } from '@wordpress/components';

const MessageControl = ( { value, onChange } ) => {
    return (
        <TextareaControl
            label={ __( 'Message', 'unadorned-announcement-bar' ) }
            value={ value }
            onChange={ onChange }
            __nextHasNoMarginBottom
        />
    );
};

const DisplayControl = ( { value, onChange } ) => {
    return (
        <ToggleControl
            label={ __( 'Display', 'unadorned-announcement-bar' ) }
            checked={ value }
            onChange={ onChange }
            __nextHasNoMarginBottom
        />
    );
};

const SizeControl = ( { value, onChange } ) => {
    return (
        <FontSizePicker
            fontSizes={ [
                {
                    name: __( 'Small', 'unadorned-announcement-bar' ),
                    size: 'small',
                    slug: 'small',
                },
                {
                    name: __( 'Medium', 'unadorned-announcement-bar' ),
                    size: 'medium',
                    slug: 'medium',
                },
                {
                    name: __( 'Large', 'unadorned-announcement-bar' ),
                    size: 'large',
                    slug: 'large',
                },
                {
                    name: __( 'Extra Large', 'unadorned-announcement-bar' ),
                    size: 'x-large',
                    slug: 'x-large',
                },
            ] }
            value={ value }
            onChange={ onChange }
            disableCustomFontSizes={ true }
            __nextHasNoMarginBottom
        />
    );
};

export {
    MessageControl,
    DisplayControl,
    SizeControl
}