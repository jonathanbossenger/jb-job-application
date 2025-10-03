import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType('jb-job-application/form', {
    title: 'Job Application Form',
    description: 'A form for users to submit job applications',
    category: 'widgets',
    icon: 'id-alt',
    supports: {
        html: false,
    },
    edit: () => {
        const blockProps = useBlockProps();
        return (
            <div {...blockProps}>
                <div style={{
                    padding: '20px',
                    border: '1px dashed #ccc',
                    backgroundColor: '#f9f9f9',
                    textAlign: 'center'
                }}>
                    <p style={{ margin: 0, fontWeight: 'bold' }}>
                        Job Application Form
                    </p>
                    <p style={{ margin: '10px 0 0', fontSize: '14px', color: '#666' }}>
                        This form will be displayed to authenticated applicants on the frontend.
                    </p>
                </div>
            </div>
        );
    },
    save: () => {
        return null; // Dynamic block, rendered by PHP
    },
});
