import esbuild from 'esbuild';
import { sassPlugin } from 'esbuild-sass-plugin';

const styles = async () => {
    try {
        await esbuild.build({
            entryPoints: [ 'public/flex.scss' ],
            target: [ 'es2022', 'chrome90', 'edge90', 'firefox90', 'safari14' ],
            plugins: [ sassPlugin() ],
            minify: true,
            outfile: 'public/flex.min.css',
        });
        console.log('\x1b[32mSUCCESS\x1b[0m', 'Styles bundled');
    } catch (e) {
        console.log('\x1b[31mERROR\x1b[0m', `Styles: ${ e.message }`);
    }
};

await styles();
