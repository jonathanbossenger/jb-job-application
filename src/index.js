import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.css';
import './style.css';

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
                    backgroundColor: '#f9f9f9'
                }}>
                    <p style={{ margin: '0 0 20px', fontWeight: 'bold', fontSize: '16px' }}>
                        Job Application Form (Preview)
                    </p>
                    <div style={{ marginBottom: '15px' }}>
                        <label style={{ display: 'block', marginBottom: '5px', fontWeight: '500' }}>
                            First Name <span style={{ color: '#dc3232' }}>*</span>
                        </label>
                        <input 
                            type="text" 
                            disabled 
                            style={{ 
                                width: '100%', 
                                padding: '8px', 
                                border: '1px solid #ddd',
                                borderRadius: '4px',
                                backgroundColor: '#f5f5f5'
                            }} 
                        />
                    </div>
                    <div style={{ marginBottom: '15px' }}>
                        <label style={{ display: 'block', marginBottom: '5px', fontWeight: '500' }}>
                            Last Name <span style={{ color: '#dc3232' }}>*</span>
                        </label>
                        <input 
                            type="text" 
                            disabled 
                            style={{ 
                                width: '100%', 
                                padding: '8px', 
                                border: '1px solid #ddd',
                                borderRadius: '4px',
                                backgroundColor: '#f5f5f5'
                            }} 
                        />
                    </div>
                    <div style={{ marginBottom: '15px' }}>
                        <label style={{ display: 'block', marginBottom: '5px', fontWeight: '500' }}>
                            Email <span style={{ color: '#dc3232' }}>*</span>
                        </label>
                        <input 
                            type="email" 
                            disabled 
                            style={{ 
                                width: '100%', 
                                padding: '8px', 
                                border: '1px solid #ddd',
                                borderRadius: '4px',
                                backgroundColor: '#f5f5f5'
                            }} 
                        />
                    </div>
                    <div style={{ marginBottom: '15px' }}>
                        <label style={{ display: 'block', marginBottom: '5px', fontWeight: '500' }}>
                            Phone <span style={{ color: '#dc3232' }}>*</span>
                        </label>
                        <input 
                            type="tel" 
                            disabled 
                            style={{ 
                                width: '100%', 
                                padding: '8px', 
                                border: '1px solid #ddd',
                                borderRadius: '4px',
                                backgroundColor: '#f5f5f5'
                            }} 
                        />
                    </div>
                    <div style={{ marginBottom: '15px' }}>
                        <label style={{ display: 'block', marginBottom: '5px', fontWeight: '500' }}>
                            Resume (PDF only) <span style={{ color: '#dc3232' }}>*</span>
                        </label>
                        <input 
                            type="file" 
                            disabled 
                            style={{ 
                                width: '100%', 
                                padding: '8px', 
                                border: '1px solid #ddd',
                                borderRadius: '4px',
                                backgroundColor: '#f5f5f5'
                            }} 
                        />
                        <small style={{ color: '#666', fontSize: '12px' }}>
                            Maximum file size: 5MB
                        </small>
                    </div>
                    <div>
                        <button 
                            type="button" 
                            disabled 
                            style={{ 
                                padding: '10px 20px', 
                                backgroundColor: '#2271b1',
                                color: '#fff',
                                border: 'none',
                                borderRadius: '4px',
                                fontSize: '14px',
                                cursor: 'not-allowed',
                                opacity: '0.7'
                            }}
                        >
                            Submit Application
                        </button>
                    </div>
                </div>
            </div>
        );
    },
    save: () => {
        return null; // Dynamic block, rendered by PHP
    },
});
