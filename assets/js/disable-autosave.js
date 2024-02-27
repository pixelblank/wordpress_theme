console.log('admin');
if (typeof autosaveLocal !== 'undefined' && autosaveLocal.disable) {
    autosaveLocal.disable();
}

if (typeof wp !== 'undefined' && wp.autosave && wp.autosave.server) {
    wp.autosave.server.suspend();
}