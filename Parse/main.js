const electron = require('electron');
const { app } = electron;
const { contentTracing } = electron;
const { BrowserWindow } = electron;
let win;
function createWindow() {
    // 创建窗口并加载页面
    win = new BrowserWindow({ width: 1024, height: 700 });
    win.loadURL(`http://www.tianlonggame.com/`);

    // 打开窗口的调试工具
    //   win.webContents.openDevTools();
    // 窗口关闭的监听
    win.on('closed', () => {
        win = null;
    });

    const options = {
        categoryFilter: '*',
        traceOptions: 'record-until-full,enable-sampling'
    }

    contentTracing.startRecording(options, function () {
        console.log('Tracing started');

        setTimeout(function () {
            contentTracing.stopRecording('', function (path) {
                console.log('Tracing data recorded to ' + path);
            });
        }, 5000);
    });

    let contents = win.webContents
    console.log(contents)
}

app.on('ready', createWindow);
app.on('window-all-closed', () => {
    if (process.platform !== 'darwin') {
        app.quit();
    }
});

app.on('activate', () => {
    if (win === null) {
        createWindow();
    }
});