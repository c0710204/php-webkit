using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.Diagnostics;
namespace phpservices
{
    public partial class php : Control
    {
        public php()
        {
            InitializeComponent();
        }

        protected override void OnPaint(PaintEventArgs pe)
        {
            base.OnPaint(pe);
        }
        public Process phphost;
        public int port;
        public void Start(int port=50000)
        {
            // TODO:  在此处添加代码以启动服务。
            phphost = new Process();
            phphost.StartInfo.WorkingDirectory = System.Environment.CurrentDirectory+"\\www";
            phphost.StartInfo.WindowStyle = System.Diagnostics.ProcessWindowStyle.Hidden;
            phphost.StartInfo.FileName = System.Environment.CurrentDirectory + "\\php-mobile.exe";
            phphost.StartInfo.Arguments = " -S 127.0.0.1:" + port.ToString();
            phphost.StartInfo.CreateNoWindow = false;
            phphost.StartInfo.UseShellExecute = true;
            phphost.Start();
            this.port = port;
            this.notifyIcon1.BalloonTipText = "运行于127.0.0.1:" + port.ToString();
            this.notifyIcon1.ShowBalloonTip(30);
        }

        public void Stop()
        {
            // TODO:  在此处添加代码以执行停止服务所需的关闭操作。
            try
            {
                phphost.Kill();
            }
            catch (Exception)
            {

                //throw;
            }
        }
    }
}
