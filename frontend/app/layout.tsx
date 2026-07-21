import React from 'react';
import './globals.css';

export const metadata = {
  title: 'SAPZ Enterprise Delivery Programme',
  description: 'Enterprise Management System (ESM) & Central Knowledge Repository (CKR)',
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="en">
      <body className="bg-slate-900 text-slate-100 antialiased">{children}</body>
    </html>
  );
}
