'use client'

import React from 'react'

export function DataTable({
  children,
  footer,
  className = '',
  striped = true,
}: {
  children: React.ReactNode
  footer?: React.ReactNode
  className?: string
  striped?: boolean
}) {
  return (
    <div className={`overflow-hidden bg-white border border-gray-200 rounded-lg ${className}`}>
      <div className="overflow-x-auto">
        <table
          className={`w-full min-w-[640px] text-left border-collapse ${
            striped ? '[& tbody tr:nth-child(even)]:bg-gray-50 ' : ''
          }`}
        >
          {children}
        </table>
      </div>
      {footer}
    </div>
  )
}

export function DataTableHeader({ children }: { children: React.ReactNode }) {
  return (
    <thead>
      <tr className="bg-gray-100 border-b border-gray-200">
        {children}
      </tr>
    </thead>
  )
}

export function DataTableHeaderCell({
  children,
  align = 'left',
  className = '',
}: {
  children: React.ReactNode
  align?: 'left' | 'right' | 'center'
  className?: string
}) {
  const alignClass = align === 'right' ? 'text-right' : align === 'center' ? 'text-center' : 'text-left'
  return (
    <th className={`px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200 ${alignClass} ${className}`}>
      {children}
    </th>
  )
}

export function DataTableBody({ children }: { children: React.ReactNode }) {
  return <tbody className="divide-y divide-gray-200">{children}</tbody>
}

export function DataTableRow({ children, className = '' }: { children: React.ReactNode; className?: string }) {
  return <tr className={`hover:bg-gray-50 ${className}`}>{children}</tr>
}

export function DataTableCell({
  children,
  align = 'left',
  className = '',
}: {
  children: React.ReactNode
  align?: 'left' | 'right' | 'center'
  className?: string
}) {
  const alignClass = align === 'right' ? 'text-right' : align === 'center' ? 'text-center' : 'text-left'
  return <td className={`px-4 py-3 text-sm text-gray-700 ${alignClass} ${className}`}>{children}</td>
}

export function DataTableFooter({ children, className = '' }: { children: React.ReactNode; className?: string }) {
  return (
    <div className={`flex items-center justify-between px-4 py-3 bg-gray-50 border-t border-gray-200 text-sm text-gray-600 ${className}`}>
      {children}
    </div>
  )
}
