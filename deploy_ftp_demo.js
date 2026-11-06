const ftp = require('basic-ftp');
const path = require('path');
const fs = require('fs');

async function deployToDemo() {
    const client = new ftp.Client();
    client.ftp.verbose = true;

    try {
        console.log('--- CONNESSIONE FTP ARUBA IN CORSO ---');
        await client.access({
            host: 'ftp.sicilybiketours.it',
            user: '11006175@aruba.it',
            password: '123Mariella?!',
            port: 21,
            secure: true,
            secureOptions: {
                rejectUnauthorized: false
            }
        });

        console.log('-> Connessione FTP stabilita con successo!');
        
        const remoteBase = '/www.sicilybiketours.it/demo';
        console.log(`-> Accesso alla cartella remota: ${remoteBase}...`);
        await client.cd(remoteBase);
        console.log('-> Directory remota corrente:', await client.pwd());

        // File principali da sincronizzare
        const filesToUpload = [
            // Pagine PHP Principali
            { local: 'index.php', remote: 'index.php' },
            { local: 'escursioni.php', remote: 'escursioni.php' },
            { local: 'tour.php', remote: 'tour.php' },
            { local: 'personalizza-tour.php', remote: 'personalizza-tour.php' },
            { local: 'chi-siamo.php', remote: 'chi-siamo.php' },
            { local: 'contatti.php', remote: 'contatti.php' },
            { local: 'magazine.php', remote: 'magazine.php' },
            { local: 'tour-dettaglio.php', remote: 'tour-dettaglio.php' },
            { local: 'articolo.php', remote: 'articolo.php' },

            // CSS e JS
            { local: 'assets/css/style.css', remote: 'assets/css/style.css' },
            { local: 'assets/js/qrcode.min.js', remote: 'assets/js/qrcode.min.js' },

            // Includes
            { local: 'includes/booking-modal.php', remote: 'includes/booking-modal.php' },
            { local: 'includes/custom-tour-builder.php', remote: 'includes/custom-tour-builder.php' },
            { local: 'includes/tour-card.php', remote: 'includes/tour-card.php' },
            { local: 'includes/navbar.php', remote: 'includes/navbar.php' },
            { local: 'includes/header.php', remote: 'includes/header.php' },
            { local: 'includes/footer.php', remote: 'includes/footer.php' },

            // Config e Dati
            { local: 'config/config.php', remote: 'config/config.php' },
            { local: 'config/lang.php', remote: 'config/lang.php' },
            { local: 'data/partners.json', remote: 'data/partners.json' },
            { local: 'data/configurator.json', remote: 'data/configurator.json' },
            { local: 'data/leads.json', remote: 'data/leads.json' },
            { local: 'data/tours.json', remote: 'data/tours.json' },

            // API e Admin
            { local: 'api/submit-lead.php', remote: 'api/submit-lead.php' },
            { local: 'admin/index.php', remote: 'admin/index.php' }
        ];

        for (const item of filesToUpload) {
            if (fs.existsSync(item.local)) {
                const remoteDir = path.dirname(item.remote);
                if (remoteDir && remoteDir !== '.') {
                    await client.ensureDir(`${remoteBase}/${remoteDir}`);
                    await client.cd(remoteBase);
                }
                console.log(`Caricamento: ${item.local} -> ${item.remote}`);
                await client.uploadFrom(item.local, `${remoteBase}/${item.remote}`);
            } else {
                console.warn(`File locale non trovato: ${item.local}`);
            }
        }

        console.log('--- DEPLOY FTP SU DEMO COMPLETATO CON SUCCESSO! ---');

    } catch (err) {
        console.error('--- ERRORE DURANTE IL DEPLOY FTP ---');
        console.error(err.message || err);
        if (err.message && err.message.includes('530')) {
            console.error('\n[AVVISO ARUBA]: Accesso FTP bloccato per policy di sicurezza o filtro IP attivo.');
            console.error('Per sbloccarlo: accedere al pannello admin.aruba.it -> Hosting Linux -> Gestione Accessi FTP e autorizzare l\'IP attuale.');
        }
    } finally {
        client.close();
    }
}

deployToDemo();
