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
    public partial class Form1 : Form
    {
        
        public Form1()
        {
            InitializeComponent();
        }

        private void notifyIcon1_MouseDoubleClick(object sender, MouseEventArgs e)
        {

        }

        private void Form1_Load(object sender, EventArgs e)
        {
            Random rd = new Random();
            int port = rd.Next(60000-40000)+40000;
            php1.Start(port);
            webBrowser1.Navigate("http://127.0.0.1:" + port.ToString());
            
        }

        private void webBrowser1_DocumentCompleted(object sender, WebBrowserDocumentCompletedEventArgs e)
        {
        }

        private void Form1_FormClosed(object sender, FormClosedEventArgs e)
        {
            php1.Stop();
            
        }
    }
}
